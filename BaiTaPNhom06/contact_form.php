<?php
require_once 'functions.php';
$uid = yeu_cau_dang_nhap();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);   // id > 0: sửa, id = 0: thêm mới
$ds_nhom = lay_nhom($pdo, $uid);
$ids_nhom = array_map('intval', array_column($ds_nhom, 'id'));

$cot = ['ho_ten', 'so_dien_thoai', 'email', 'ngay_sinh', 'gioi_tinh', 'don_vi', 'dia_chi', 'ghi_chu'];
$d = array_fill_keys($cot, '');
$d['gioi_tinh'] = 'Khác';
$d['id_nhom'] = 0;
$d['yeu_thich'] = 0;
$loi = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $id > 0) {
    $row = lay_lien_he($pdo, $id, $uid);
    if (!$row) { chuyen_huong('index.php', 'err', "Không tìm thấy liên hệ có ID = $id để sửa."); }
    foreach ($cot as $k) { $d[$k] = (string)($row[$k] ?? ''); }
    $d['id_nhom'] = (int)$row['id_nhom'];
    $d['yeu_thich'] = (int)$row['yeu_thich'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    if ($id > 0 && !lay_lien_he($pdo, $id, $uid)) {
        chuyen_huong('index.php', 'err', "Không tìm thấy liên hệ có ID = $id (có thể đã bị xóa).");
    }
    foreach ($cot as $k) { $d[$k] = trim($_POST[$k] ?? ''); }
    $d['id_nhom'] = (int)($_POST['id_nhom'] ?? 0);
    $d['yeu_thich'] = isset($_POST['yeu_thich']) ? 1 : 0;

    // ----- Kiểm tra dữ liệu đầu vào -----
    if ($d['ho_ten'] === '') { $loi[] = 'Họ và tên không được để trống.'; }
    elseif (mb_strlen($d['ho_ten']) > 100) { $loi[] = 'Họ và tên tối đa 100 ký tự.'; }

    if ($d['so_dien_thoai'] === '') { $loi[] = 'Số điện thoại không được để trống.'; }
    elseif (!hop_le_sdt($d['so_dien_thoai'])) { $loi[] = 'Số điện thoại không hợp lệ (VD: 0987654321 hoặc +84987654321).'; }
    else {
        $st = $pdo->prepare("SELECT ho_ten FROM lien_he WHERE id_nguoi_dung = :u AND so_dien_thoai = :s AND id <> :id");
        $st->execute([':u' => $uid, ':s' => $d['so_dien_thoai'], ':id' => $id]);
        if ($trung = $st->fetchColumn()) { $loi[] = 'Số điện thoại này đã có trong danh bạ (liên hệ: ' . $trung . ').'; }
    }
    if ($d['email'] !== '' && (!filter_var($d['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($d['email']) > 100)) {
        $loi[] = 'Email không hợp lệ.';
    }
    if ($d['ngay_sinh'] !== '') {
        $dt = DateTime::createFromFormat('Y-m-d', $d['ngay_sinh']);
        if (!$dt || $dt->format('Y-m-d') !== $d['ngay_sinh'] || $dt > new DateTime()) { $loi[] = 'Ngày sinh không hợp lệ.'; }
    }
    if (!in_array($d['gioi_tinh'], GIOI_TINH, true)) { $loi[] = 'Giới tính không hợp lệ.'; }
    if ($d['id_nhom'] !== 0 && !in_array($d['id_nhom'], $ids_nhom, true)) { $loi[] = 'Nhóm đã chọn không tồn tại.'; }
    if (mb_strlen($d['don_vi']) > 100 || mb_strlen($d['dia_chi']) > 255) { $loi[] = 'Đơn vị tối đa 100 ký tự, địa chỉ tối đa 255 ký tự.'; }

    // ----- Lưu vào CSDL -----
    if (!$loi) {
        $nul = fn($v) => $v === '' ? null : $v;
        $tham = [
            ':nhom' => $d['id_nhom'] ?: null, ':ten' => $d['ho_ten'], ':gt' => $d['gioi_tinh'],
            ':ns' => $nul($d['ngay_sinh']), ':sdt' => $d['so_dien_thoai'], ':email' => $nul($d['email']),
            ':dv' => $nul($d['don_vi']), ':dc' => $nul($d['dia_chi']), ':gc' => $nul($d['ghi_chu']),
            ':yt' => $d['yeu_thich'], ':u' => $uid,
        ];
        try {
            if ($id > 0) {
                $st = $pdo->prepare("UPDATE lien_he SET id_nhom = :nhom, ho_ten = :ten, gioi_tinh = :gt, ngay_sinh = :ns,
                        so_dien_thoai = :sdt, email = :email, don_vi = :dv, dia_chi = :dc, ghi_chu = :gc, yeu_thich = :yt
                        WHERE id = :id AND id_nguoi_dung = :u");
                $st->execute($tham + [':id' => $id]);
                chuyen_huong("contact_view.php?id=$id", 'ok', "Đã cập nhật liên hệ '{$d['ho_ten']}'.");
            } else {
                $st = $pdo->prepare("INSERT INTO lien_he (id_nguoi_dung, id_nhom, ho_ten, gioi_tinh, ngay_sinh, so_dien_thoai,
                        email, don_vi, dia_chi, ghi_chu, yeu_thich)
                        VALUES (:u, :nhom, :ten, :gt, :ns, :sdt, :email, :dv, :dc, :gc, :yt)");
                $st->execute($tham);
                chuyen_huong('contact_view.php?id=' . $pdo->lastInsertId(), 'ok', "Đã thêm liên hệ '{$d['ho_ten']}'. Bạn có thể kết nối liên hệ này với người khác ở bên dưới.");
            }
        } catch (PDOException $ex) {
            $loi[] = 'Lỗi cơ sở dữ liệu: ' . $ex->getMessage();
        }
    }
}

$tieu_de = $id > 0 ? 'Sửa liên hệ' : 'Thêm liên hệ';
include 'header.php';
?>
<div class="card <?= $id > 0 ? 'editing' : '' ?>">
    <h3><?= $id > 0 ? "Chỉnh sửa liên hệ (ID: $id)" : 'Thêm liên hệ mới' ?></h3>
    <?php foreach ($loi as $m): ?><div class="alert alert-err"><?= e($m) ?></div><?php endforeach; ?>
    <form method="POST" action="contact_form.php">
        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="grid-3">
            <div><label>Họ và tên (*)</label><input type="text" name="ho_ten" maxlength="100" value="<?= e($d['ho_ten']) ?>"></div>
            <div><label>Số điện thoại (*)</label><input type="text" name="so_dien_thoai" maxlength="15" value="<?= e($d['so_dien_thoai']) ?>" placeholder="0987654321"></div>
            <div><label>Email</label><input type="text" name="email" maxlength="100" value="<?= e($d['email']) ?>"></div>
            <div><label>Ngày sinh</label><input type="date" name="ngay_sinh" max="<?= date('Y-m-d') ?>" value="<?= e($d['ngay_sinh']) ?>"></div>
            <div><label>Giới tính</label>
                <select name="gioi_tinh">
                    <?php foreach (GIOI_TINH as $g): ?><option <?= $d['gioi_tinh'] === $g ? 'selected' : '' ?>><?= e($g) ?></option><?php endforeach; ?>
                </select></div>
            <div><label>Nhóm</label>
                <select name="id_nhom">
                    <option value="0">— Chưa phân nhóm —</option>
                    <?php foreach ($ds_nhom as $n): ?>
                        <option value="<?= (int)$n['id'] ?>" <?= $d['id_nhom'] === (int)$n['id'] ? 'selected' : '' ?>><?= e($n['ten_nhom']) ?></option>
                    <?php endforeach; ?>
                </select></div>
            <div><label>Đơn vị (lớp / cơ quan)</label><input type="text" name="don_vi" maxlength="100" value="<?= e($d['don_vi']) ?>"></div>
            <div class="span2"><label>Địa chỉ</label><input type="text" name="dia_chi" maxlength="255" value="<?= e($d['dia_chi']) ?>"></div>
        </div>
        <label>Ghi chú</label>
        <textarea name="ghi_chu" rows="3"><?= e($d['ghi_chu']) ?></textarea>
        <label class="check"><input type="checkbox" name="yeu_thich" value="1" <?= $d['yeu_thich'] ? 'checked' : '' ?>> ★ Đánh dấu yêu thích</label>
        <button class="btn <?= $id > 0 ? 'btn-warn' : '' ?>"><?= $id > 0 ? 'Cập nhật' : 'Lưu liên hệ' ?></button>
        <a class="btn btn-sec" href="<?= $id > 0 ? "contact_view.php?id=$id" : 'index.php' ?>">Hủy</a>
    </form>
</div>
<?php include 'footer.php'; ?>
