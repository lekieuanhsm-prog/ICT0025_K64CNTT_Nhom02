<?php
require_once 'functions.php';
$uid = yeu_cau_dang_nhap();
$tieu_de = 'Danh bạ';
$qs = $_SERVER['QUERY_STRING'] ?? '';

// Bật/tắt yêu thích (POST) rồi quay lại đúng trang đang xem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    $st = $pdo->prepare("UPDATE lien_he SET yeu_thich = 1 - yeu_thich WHERE id = :id AND id_nguoi_dung = :u");
    $st->execute([':id' => (int)($_POST['id'] ?? 0), ':u' => $uid]);
    chuyen_huong('index.php' . ($qs !== '' ? "?$qs" : ''));
}

// ----- Thống kê -----
$st = $pdo->prepare("SELECT COUNT(*) AS tong, COALESCE(SUM(yeu_thich), 0) AS yt FROM lien_he WHERE id_nguoi_dung = :u");
$st->execute([':u' => $uid]);
$tk = $st->fetch();

$st = $pdo->prepare("SELECT COUNT(*) FROM quan_he qh JOIN lien_he lh ON lh.id = qh.id_lien_he_a WHERE lh.id_nguoi_dung = :u");
$st->execute([':u' => $uid]);
$so_qh = (int)$st->fetchColumn();

$st = $pdo->prepare("SELECT id, ho_ten, ngay_sinh FROM lien_he
                     WHERE id_nguoi_dung = :u AND MONTH(ngay_sinh) = MONTH(CURDATE())
                     ORDER BY DAY(ngay_sinh)");
$st->execute([':u' => $uid]);
$sinh_nhat = $st->fetchAll();

// ----- Tìm kiếm / lọc / phân trang -----
$q     = trim($_GET['q'] ?? '');
$nhom  = (int)($_GET['nhom'] ?? 0);
$chi_yt = isset($_GET['yt']);
$trang = max(1, (int)($_GET['trang'] ?? 1));
$moi_trang = 8;

$where = ['lh.id_nguoi_dung = :uid'];
$tham_so = [':uid' => $uid];
if ($q !== '') {
    // Dùng tên tham số khác nhau (prepared statement thật không cho lặp lại tên)
    $where[] = "(lh.ho_ten LIKE :q1 OR lh.so_dien_thoai LIKE :q2 OR lh.email LIKE :q3 OR lh.don_vi LIKE :q4)";
    foreach ([':q1', ':q2', ':q3', ':q4'] as $k) { $tham_so[$k] = "%$q%"; }
}
if ($nhom > 0)  { $where[] = 'lh.id_nhom = :nhom'; $tham_so[':nhom'] = $nhom; }
if ($chi_yt)    { $where[] = 'lh.yeu_thich = 1'; }
$sql_where = implode(' AND ', $where);

$st = $pdo->prepare("SELECT COUNT(*) FROM lien_he lh WHERE $sql_where");
$st->execute($tham_so);
$tong = (int)$st->fetchColumn();
$so_trang = max(1, (int)ceil($tong / $moi_trang));
$trang = min($trang, $so_trang);
$offset = ($trang - 1) * $moi_trang;

$st = $pdo->prepare("SELECT lh.*, nh.ten_nhom,
        (SELECT COUNT(*) FROM quan_he qh WHERE qh.id_lien_he_a = lh.id OR qh.id_lien_he_b = lh.id) AS so_qh
    FROM lien_he lh LEFT JOIN nhom_lien_he nh ON nh.id = lh.id_nhom
    WHERE $sql_where
    ORDER BY lh.yeu_thich DESC, lh.ho_ten ASC
    LIMIT $moi_trang OFFSET $offset");
$st->execute($tham_so);
$ds = $st->fetchAll();
$ds_nhom = lay_nhom($pdo, $uid);

function lk_trang(int $t): string { $p = $_GET; $p['trang'] = $t; return 'index.php?' . http_build_query($p); }

include 'header.php';
?>
<div class="stats">
    <div class="stat"><b><?= (int)$tk['tong'] ?></b><span>Liên hệ</span></div>
    <div class="stat"><b><?= (int)$tk['yt'] ?></b><span>Yêu thích</span></div>
    <div class="stat"><b><?= count($ds_nhom) ?></b><span>Nhóm</span></div>
    <div class="stat"><b><?= $so_qh ?></b><span>Mối quan hệ</span></div>
</div>

<?php if ($sinh_nhat): ?>
<div class="card">
    <h3>🎂 Sinh nhật trong tháng này</h3>
    <?php foreach ($sinh_nhat as $s): ?>
        <a class="chip" href="contact_view.php?id=<?= (int)$s['id'] ?>">
            <?= e($s['ho_ten']) ?> – <?= e((new DateTime($s['ngay_sinh']))->format('d/m')) ?>
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="card">
    <form method="GET" class="filter">
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="Tìm theo tên, SĐT, email, đơn vị...">
        <select name="nhom">
            <option value="0">Tất cả nhóm</option>
            <?php foreach ($ds_nhom as $n): ?>
                <option value="<?= (int)$n['id'] ?>" <?= $nhom === (int)$n['id'] ? 'selected' : '' ?>><?= e($n['ten_nhom']) ?></option>
            <?php endforeach; ?>
        </select>
        <label class="check"><input type="checkbox" name="yt" value="1" <?= $chi_yt ? 'checked' : '' ?>> Yêu thích</label>
        <button class="btn">Lọc</button>
        <a class="btn btn-sec" href="index.php">Xóa lọc</a>
    </form>
</div>

<div class="card">
    <h3>Danh sách liên hệ (<?= $tong ?>)</h3>
    <div class="table-wrap">
    <table>
        <thead><tr><th></th><th>Họ và tên</th><th>Số điện thoại</th><th>Email</th><th>Nhóm</th><th>Kết nối</th><th>Thao tác</th></tr></thead>
        <tbody>
        <?php if (!$ds): ?>
            <tr><td colspan="7" class="center muted">Không có liên hệ nào phù hợp.</td></tr>
        <?php endif; ?>
        <?php foreach ($ds as $c): ?>
            <tr>
                <td>
                    <form method="POST" action="index.php<?= $qs !== '' ? '?' . e($qs) : '' ?>" class="inline-form">
                        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
                        <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                        <button class="star" title="Yêu thích"><?= $c['yeu_thich'] ? '★' : '☆' ?></button>
                    </form>
                </td>
                <td>
                    <span class="avatar sm"><?= e(chu_cai($c['ho_ten'])) ?></span>
                    <a href="contact_view.php?id=<?= (int)$c['id'] ?>"><b><?= e($c['ho_ten']) ?></b></a>
                </td>
                <td><?= e($c['so_dien_thoai']) ?></td>
                <td><?= e($c['email'] ?? '') ?></td>
                <td><?= $c['ten_nhom'] ? '<span class="badge">' . e($c['ten_nhom']) . '</span>' : '<span class="muted">—</span>' ?></td>
                <td>🔗 <?= (int)$c['so_qh'] ?></td>
                <td>
                    <a class="btn btn-sm" href="contact_view.php?id=<?= (int)$c['id'] ?>">Xem</a>
                    <a class="btn btn-warn btn-sm" href="contact_form.php?id=<?= (int)$c['id'] ?>">Sửa</a>
                    <a class="btn btn-del btn-sm" href="contact_delete.php?id=<?= (int)$c['id'] ?>">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <?php if ($so_trang > 1): ?>
    <div class="pager">
        <?php for ($t = 1; $t <= $so_trang; $t++): ?>
            <a class="<?= $t === $trang ? 'cur' : '' ?>" href="<?= e(lk_trang($t)) ?>"><?= $t ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
