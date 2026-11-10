<?php
// 1. Khai báo biến ban đầu
$ma_sv = "";
$ho_ten = "";
$lop = "K64CNTT";
$nam_sinh = "";
$email = "";
$gioi_tinh = "Nam";
$mat_khau = "";
$nhap_lai = "";
$loi = [];
$thanh_cong = false;

// 2. Xử lý khi bấm nút "Đăng ký"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_sv = trim($_POST["ma_sv"]);
    $ho_ten = trim($_POST["ho_ten"]);
    $lop = trim($_POST["lop"]);
    $nam_sinh = trim($_POST["nam_sinh"]);
    $email = trim($_POST["email"]);
    $gioi_tinh = $_POST["gioi_tinh"];
    $mat_khau = $_POST["mat_khau"];
    $nhap_lai = $_POST["nhap_lai"];

    if ($ma_sv == "") {
        $loi["ma_sv"] = "Vui lòng nhập mã sinh viên.";
    }
    if ($ho_ten == "") {
        $loi["ho_ten"] = "Vui lòng nhập họ tên.";
    }
    if ($lop == "") {
        $loi["lop"] = "Vui lòng nhập lớp học phần.";
    }
    if ($nam_sinh == "" || !ctype_digit($nam_sinh)) {
        $loi["nam_sinh"] = "Năm sinh phải là số hợp lệ.";
    }
    if ($email == "") {
        $loi["email"] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loi["email"] = "Email không đúng định dạng.";
    }
    if (strlen($mat_khau) < 6) {
        $loi["mat_khau"] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }
    if ($nhap_lai != $mat_khau) {
        $loi["nhap_lai"] = "Mật khẩu nhập lại không khớp.";
    }

    if (count($loi) == 0) {
        $thanh_cong = true;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="khung">
        <?php if ($thanh_cong) { ?>
            <h1>Đăng ký thành công</h1>
            <p class="thong-bao-dung">Xin chào <b><?php echo htmlspecialchars($ho_ten); ?></b>, thông tin đã nhận:</p>
            <table>
                <tr><th>Mã SV</th><td><?php echo htmlspecialchars($ma_sv); ?></td></tr>
                <tr><th>Họ tên</th><td><?php echo htmlspecialchars($ho_ten); ?></td></tr>
                <tr><th>Lớp</th><td><?php echo htmlspecialchars($lop); ?></td></tr>
                <tr><th>Năm sinh</th><td><?php echo (int)$nam_sinh; ?> (<?php echo (date("Y") - (int)$nam_sinh); ?> tuổi)</td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($email); ?></td></tr>
                <tr><th>Giới tính</th><td><?php echo htmlspecialchars($gioi_tinh); ?></td></tr>
                <tr><th>Mật khẩu</th><td><?php echo strlen($mat_khau); ?> ký tự</td></tr>
            </table>
            <a class="nut" href="dang_nhap.php">Đến trang đăng nhập</a>
        <?php } else { ?>
            <h1>Đăng ký</h1>
            <form method="POST" action="">
                <label for="ma_sv">Mã sinh viên</label>
                <input type="text" id="ma_sv" name="ma_sv" value="<?php echo htmlspecialchars($ma_sv); ?>" placeholder="Ví dụ: 231031002">
                <?php if (isset($loi["ma_sv"])) { ?><p class="loi"><?php echo $loi["ma_sv"]; ?></p><?php } ?>

                <label for="ho_ten">Họ tên</label>
                <input type="text" id="ho_ten" name="ho_ten" value="<?php echo htmlspecialchars($ho_ten); ?>" placeholder="Ví dụ: Lê Thị Kiều Anh">
                <?php if (isset($loi["ho_ten"])) { ?><p class="loi"><?php echo $loi["ho_ten"]; ?></p><?php } ?>

                <label for="lop">Lớp</label>
                <input type="text" id="lop" name="lop" value="<?php echo htmlspecialchars($lop); ?>">
                <?php if (isset($loi["lop"])) { ?><p class="loi"><?php echo $loi["lop"]; ?></p><?php } ?>

                <label for="nam_sinh">Năm sinh</label>
                <input type="number" id="nam_sinh" name="nam_sinh" value="<?php echo htmlspecialchars($nam_sinh); ?>" placeholder="Ví dụ: 2005">
                <?php if (isset($loi["nam_sinh"])) { ?><p class="loi"><?php echo $loi["nam_sinh"]; ?></p><?php } ?>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Ví dụ: sv@utb.edu.vn">
                <?php if (isset($loi["email"])) { ?><p class="loi"><?php echo $loi["email"]; ?></p><?php } ?>

                <label>Giới tính</label>
                <div class="lua-chon">
                    <label><input type="radio" name="gioi_tinh" value="Nam" <?php if ($gioi_tinh == "Nam") echo "checked"; ?>> Nam</label>
                    <label><input type="radio" name="gioi_tinh" value="Nữ" <?php if ($gioi_tinh == "Nữ") echo "checked"; ?>> Nữ</label>
                </div>

                <label for="mat_khau">Mật khẩu</label>
                <input type="password" id="mat_khau" name="mat_khau" placeholder="Tối thiểu 6 ký tự">
                <?php if (isset($loi["mat_khau"])) { ?><p class="loi"><?php echo $loi["mat_khau"]; ?></p><?php } ?>

                <label for="nhap_lai">Nhập lại mật khẩu</label>
                <input type="password" id="nhap_lai" name="nhap_lai" placeholder="Nhập lại mật khẩu">
                <?php if (isset($loi["nhap_lai"])) { ?><p class="loi"><?php echo $loi["nhap_lai"]; ?></p><?php } ?>

                <button type="submit" class="nut">Đăng ký</button>
            </form>
            <p class="chuyen-trang">Đã có tài khoản? <a href="dang_nhap.php">Đăng nhập</a></p>
        <?php } ?>
        <p class="chuyen-trang"><a href="index.php">← Trang chủ</a></p>
    </div>
</body>
</html>