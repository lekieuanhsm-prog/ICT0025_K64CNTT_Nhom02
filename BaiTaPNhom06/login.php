<?php
require_once 'functions.php';
if (!empty($_SESSION['uid'])) { chuyen_huong('index.php'); }
$tieu_de = 'Đăng nhập';
$loi = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    $email = trim($_POST['email'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';

    $st = $pdo->prepare("SELECT * FROM nguoi_dung WHERE email = :email");
    $st->execute([':email' => $email]);
    $u = $st->fetch();

    if ($u && password_verify($mat_khau, $u['mat_khau'])) {
        session_regenerate_id(true);
        $_SESSION['uid'] = (int)$u['id'];
        $_SESSION['ten'] = $u['ho_ten'];
        chuyen_huong('index.php');
    }
    $loi = 'Email hoặc mật khẩu không đúng.';
}
include 'header.php';
?>
<div class="card auth">
    <h3>Đăng nhập</h3>
    <?php if ($loi !== ''): ?><div class="alert alert-err"><?= e($loi) ?></div><?php endif; ?>
    <form method="POST">
        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required autofocus>
        <label>Mật khẩu</label>
        <input type="password" name="mat_khau" required>
        <button class="btn btn-block">Đăng nhập</button>
    </form>
    <p class="muted">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</div>
<?php include 'footer.php'; ?>
