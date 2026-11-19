<?php
require_once 'functions.php';
$uid = yeu_cau_dang_nhap();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$lh = lay_lien_he($pdo, $id, $uid);
if (!$lh) { chuyen_huong('index.php', 'err', "Không tìm thấy liên hệ có ID = $id (có thể đã bị xóa trước đó)."); }

// Chỉ xóa khi người dùng bấm "Xác nhận" (POST). Mở trang này bằng GET chỉ hiển thị màn hình xác nhận.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    try {
        $st = $pdo->prepare("DELETE FROM lien_he WHERE id = :id AND id_nguoi_dung = :u");
        $st->execute([':id' => $id, ':u' => $uid]);
        if ($st->rowCount() === 1) {
            chuyen_huong('index.php', 'ok', "Đã xóa liên hệ '{$lh['ho_ten']}' (ID: $id).");
        }
        chuyen_huong('index.php', 'err', "Không có dòng nào bị xóa (ID = $id).");
    } catch (PDOException $ex) {
        chuyen_huong("contact_view.php?id=$id", 'err', 'Không thể xóa liên hệ này: ' . $ex->getMessage());
    }
}

$st = $pdo->prepare("SELECT COUNT(*) FROM quan_he WHERE id_lien_he_a = :a OR id_lien_he_b = :b");
$st->execute([':a' => $id, ':b' => $id]);
$so_qh = (int)$st->fetchColumn();

$tieu_de = 'Xác nhận xóa';
include 'header.php';
?>
<div class="card deleting">
    <h3>⚠️ Xác nhận xóa liên hệ</h3>
    <p>Bạn sắp xóa <b><?= e($lh['ho_ten']) ?></b> (ID: <?= $id ?>, SĐT: <?= e($lh['so_dien_thoai']) ?>).</p>
    <?php if ($so_qh > 0): ?>
        <p>Liên hệ này đang có <b><?= $so_qh ?> kết nối</b> với người khác — các kết nối đó cũng sẽ bị xóa (những người kia vẫn còn trong danh bạ).</p>
    <?php endif; ?>
    <p>Thao tác này <b>không thể hoàn tác</b>.</p>
    <form method="POST" class="inline-form">
        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button class="btn btn-del">Xác nhận xóa</button>
    </form>
    <a class="btn btn-sec" href="contact_view.php?id=<?= $id ?>">Hủy</a>
</div>
<?php include 'footer.php'; ?>
