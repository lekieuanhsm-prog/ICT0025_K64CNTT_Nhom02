<?php
require_once 'functions.php';
$uid = yeu_cau_dang_nhap();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$lh = lay_lien_he($pdo, $id, $uid);
if (!$lh) { chuyen_huong('index.php', 'err', "Không tìm thấy liên hệ có ID = $id."); }

// ----- Thêm / xóa mối quan hệ (POST) -----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    $tb = ['err', 'Thao tác không hợp lệ.'];

    if (($_POST['action'] ?? '') === 'them_qh') {
        $khac = (int)($_POST['id_khac'] ?? 0);
        $loai = $_POST['loai'] ?? '';
        $ghi_chu = trim($_POST['ghi_chu'] ?? '');
        if ($khac === $id || !lay_lien_he($pdo, $khac, $uid)) {
            $tb = ['err', 'Liên hệ cần kết nối không hợp lệ.'];
        } elseif (!in_array($loai, LOAI_QUAN_HE, true)) {
            $tb = ['err', 'Loại quan hệ không hợp lệ.'];
        } elseif (mb_strlen($ghi_chu) > 150) {
            $tb = ['err', 'Ghi chú tối đa 150 ký tự.'];
        } else {
            try {
                // Luôn lưu id nhỏ ở cột a, id lớn ở cột b
                $st = $pdo->prepare("INSERT INTO quan_he (id_lien_he_a, id_lien_he_b, loai, ghi_chu) VALUES (:a, :b, :loai, :gc)");
                $st->execute([':a' => min($id, $khac), ':b' => max($id, $khac), ':loai' => $loai, ':gc' => $ghi_chu !== '' ? $ghi_chu : null]);
                $tb = ['ok', 'Đã kết nối hai liên hệ.'];
            } catch (PDOException $ex) {
                $tb = ['err', $ex->getCode() === '23000' ? 'Hai liên hệ này đã được kết nối rồi.' : 'Lỗi cơ sở dữ liệu: ' . $ex->getMessage()];
            }
        }
    } elseif (($_POST['action'] ?? '') === 'xoa_qh') {
        // Chỉ xóa được quan hệ thuộc về liên hệ của chính mình
        $st = $pdo->prepare("DELETE FROM quan_he WHERE id = :id
                             AND id_lien_he_a IN (SELECT id FROM lien_he WHERE id_nguoi_dung = :u)");
        $st->execute([':id' => (int)($_POST['id_qh'] ?? 0), ':u' => $uid]);
        $tb = $st->rowCount() === 1 ? ['ok', 'Đã hủy kết nối.'] : ['err', 'Không tìm thấy mối quan hệ cần xóa.'];
    }
    chuyen_huong("contact_view.php?id=$id", $tb[0], $tb[1]);
}

// ----- Các liên hệ đang kết nối (tính cả hai chiều a↔b) -----
$st = $pdo->prepare("SELECT qh.id AS id_qh, qh.loai, qh.ghi_chu AS ghi_chu_qh, k.id, k.ho_ten, k.so_dien_thoai
    FROM quan_he qh
    JOIN lien_he k ON k.id = IF(qh.id_lien_he_a = :id1, qh.id_lien_he_b, qh.id_lien_he_a)
    WHERE qh.id_lien_he_a = :id2 OR qh.id_lien_he_b = :id3
    ORDER BY qh.loai, k.ho_ten");
$st->execute([':id1' => $id, ':id2' => $id, ':id3' => $id]);
$ket_noi = $st->fetchAll();

// Liên hệ chưa kết nối (để chọn thêm)
$st = $pdo->prepare("SELECT id, ho_ten FROM lien_he
    WHERE id_nguoi_dung = :u AND id <> :id1
      AND id NOT IN (SELECT id_lien_he_b FROM quan_he WHERE id_lien_he_a = :id2
                     UNION SELECT id_lien_he_a FROM quan_he WHERE id_lien_he_b = :id3)
    ORDER BY ho_ten");
$st->execute([':u' => $uid, ':id1' => $id, ':id2' => $id, ':id3' => $id]);
$chua_ket_noi = $st->fetchAll();

// Những người cùng nhóm
$cung_nhom = [];
if ($lh['id_nhom']) {
    $st = $pdo->prepare("SELECT id, ho_ten FROM lien_he WHERE id_nguoi_dung = :u AND id_nhom = :n AND id <> :id ORDER BY ho_ten LIMIT 10");
    $st->execute([':u' => $uid, ':n' => $lh['id_nhom'], ':id' => $id]);
    $cung_nhom = $st->fetchAll();
}

$tieu_de = $lh['ho_ten'];
$t = tuoi($lh['ngay_sinh']);
include 'header.php';
?>
<div class="card">
    <div class="profile">
        <span class="avatar"><?= e(chu_cai($lh['ho_ten'])) ?></span>
        <div>
            <h2><?= e($lh['ho_ten']) ?> <?= $lh['yeu_thich'] ? '<span class="star on">★</span>' : '' ?></h2>
            <?php if ($lh['ten_nhom']): ?><span class="badge"><?= e($lh['ten_nhom']) ?></span><?php endif; ?>
            <?php if ($lh['don_vi']): ?><span class="muted"> · <?= e($lh['don_vi']) ?></span><?php endif; ?>
        </div>
        <span class="grow"></span>
        <a class="btn btn-warn" href="contact_form.php?id=<?= $id ?>">Sửa</a>
        <a class="btn btn-del" href="contact_delete.php?id=<?= $id ?>">Xóa</a>
        <a class="btn btn-sec" href="index.php">← Danh bạ</a>
    </div>
    <dl class="info">
        <dt>📞 Điện thoại</dt><dd><a href="tel:<?= e($lh['so_dien_thoai']) ?>"><?= e($lh['so_dien_thoai']) ?></a></dd>
        <dt>✉️ Email</dt><dd><?= $lh['email'] ? '<a href="mailto:' . e($lh['email']) . '">' . e($lh['email']) . '</a>' : '<span class="muted">—</span>' ?></dd>
        <dt>🎂 Ngày sinh</dt><dd><?= $lh['ngay_sinh'] ? e((new DateTime($lh['ngay_sinh']))->format('d/m/Y')) . " ($t tuổi)" : '<span class="muted">—</span>' ?></dd>
        <dt>⚧ Giới tính</dt><dd><?= e($lh['gioi_tinh']) ?></dd>
        <dt>📍 Địa chỉ</dt><dd><?= $lh['dia_chi'] ? e($lh['dia_chi']) : '<span class="muted">—</span>' ?></dd>
        <dt>📝 Ghi chú</dt><dd><?= $lh['ghi_chu'] ? nl2br(e($lh['ghi_chu'])) : '<span class="muted">—</span>' ?></dd>
    </dl>
</div>

<div class="card">
    <h3>🔗 Kết nối (<?= count($ket_noi) ?>)</h3>
    <?php if (!$ket_noi): ?><p class="muted">Chưa kết nối với liên hệ nào.</p><?php endif; ?>
    <div class="links">
    <?php foreach ($ket_noi as $k): ?>
        <div class="link-item">
            <span class="avatar sm"><?= e(chu_cai($k['ho_ten'])) ?></span>
            <div>
                <a href="contact_view.php?id=<?= (int)$k['id'] ?>"><b><?= e($k['ho_ten']) ?></b></a>
                <span class="badge"><?= e($k['loai']) ?></span><br>
                <small class="muted"><?= e($k['so_dien_thoai']) ?><?= $k['ghi_chu_qh'] ? ' · ' . e($k['ghi_chu_qh']) : '' ?></small>
            </div>
            <form method="POST" class="inline-form" onsubmit="return confirm('Hủy kết nối này? (Hai liên hệ vẫn còn trong danh bạ)');">
                <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
                <input type="hidden" name="action" value="xoa_qh">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="id_qh" value="<?= (int)$k['id_qh'] ?>">
                <button class="btn btn-del btn-sm" title="Hủy kết nối">✕</button>
            </form>
        </div>
    <?php endforeach; ?>
    </div>

    <?php if ($chua_ket_noi): ?>
    <form method="POST" class="filter">
        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
        <input type="hidden" name="action" value="them_qh">
        <input type="hidden" name="id" value="<?= $id ?>">
        <select name="id_khac" required>
            <option value="">— Chọn liên hệ —</option>
            <?php foreach ($chua_ket_noi as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['ho_ten']) ?></option><?php endforeach; ?>
        </select>
        <select name="loai">
            <?php foreach (LOAI_QUAN_HE as $l): ?><option><?= e($l) ?></option><?php endforeach; ?>
        </select>
        <input type="text" name="ghi_chu" maxlength="150" placeholder="Ghi chú (VD: anh trai, cùng lớp...)">
        <button class="btn">+ Kết nối</button>
    </form>
    <?php endif; ?>
</div>

<?php if ($cung_nhom): ?>
<div class="card">
    <h3>👥 Cùng nhóm “<?= e($lh['ten_nhom']) ?>”</h3>
    <?php foreach ($cung_nhom as $c): ?>
        <a class="chip" href="contact_view.php?id=<?= (int)$c['id'] ?>"><?= e($c['ho_ten']) ?></a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>
