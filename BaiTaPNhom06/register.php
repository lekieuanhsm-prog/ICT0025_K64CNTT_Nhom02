<?php
require_once 'functions.php';
if (!empty($_SESSION['uid'])) { chuyen_huong('index.php'); }
$tieu_de = 'Đăng ký';
$loi = '';
$ho_ten = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    $ho_ten   = trim($_POST['ho_ten'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';
    $nhap_lai = $_POST['nhap_lai'] ?? '';

    if (mb_strlen($ho_ten) < 2 || mb_strlen($ho_ten) > 100) {
        $loi = 'Họ và tên phải từ 2 đến 100 ký tự.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
        $loi = 'Email không hợp lệ.';
    } elseif (strlen($mat_khau) < 6) {
        $loi = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif ($mat_khau !== $nhap_lai) {
        $loi = 'Mật khẩu nhập lại không khớp.';
    } else {
        try {
            $st = $pdo->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau) VALUES (:ten, :email, :mk)");
            $st->execute([':ten' => $ho_ten, ':email' => $email, ':mk' => password_hash($mat_khau, PASSWORD_DEFAULT)]);
            $uid = (int)$pdo->lastInsertId();

            // Tạo sẵn vài nhóm mặc định cho người dùng mới
            $st = $pdo->prepare("INSERT INTO nhom_lien_he (id_nguoi_dung, ten_nhom) VALUES (:u, :n)");
            foreach (['Gia đình', 'Bạn bè', 'Công việc'] as $n) { $st->execute([':u' => $uid, ':n' => $n]); }

            chuyen_huong('login.php', 'ok', 'Đăng ký thành công! Hãy đăng nhập.');
        } catch (PDOException $ex) {
            $loi = $ex->getCode() === '23000' ? 'Email này đã được đăng ký.' : 'Lỗi cơ sở dữ liệu: ' . $ex->getMessage();
        }
    }
}
include 'header.php';
?>
<div class="card auth">
    <h3>Đăng ký tài khoản</h3>
    <?php if ($loi !== ''): ?><div class="alert alert-err"><?= e($loi) ?></div><?php endif; ?>
    <form method="POST">
        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
        <label>Họ và tên</label>
        <input type="text" name="ho_ten" value="<?= e($ho_ten) ?>" maxlength="100" required>
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" maxlength="100" required>
        <label>Mật khẩu (≥ 6 ký tự)</label>
        <input type="password" name="mat_khau" required>
        <label>Nhập lại mật khẩu</label>
        <input type="password" name="nhap_lai" required>
        <button class="btn btn-block">Đăng ký</button>
    </form>
    <p class="muted">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</div>
<?php include 'footer.php'; ?>
