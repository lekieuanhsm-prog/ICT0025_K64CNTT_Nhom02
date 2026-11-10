<?php
$tai_khoan = "";
$mat_khau = "";
$loi = [];
$thanh_cong = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tai_khoan = trim($_POST["tai_khoan"]);
    $mat_khau = $_POST["mat_khau"];

    if ($tai_khoan == "") {
        $loi["tai_khoan"] = "Vui lòng nhập Email hoặc Mã sinh viên.";
    }
    if ($mat_khau == "") {
        $loi["mat_khau"] = "Vui lòng nhập mật khẩu.";
    } elseif (strlen($mat_khau) < 6) {
        $loi["mat_khau"] = "Mật khẩu phải có ít nhất 6 ký tự.";
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
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="khung">
        <?php if ($thanh_cong) { ?>
            <h1>Đăng nhập thành công</h1>
            <p class="thong-bao-dung">Thông tin phiên đăng nhập:</p>
            <table>
                <tr><th>Tài khoản</th><td><?php echo htmlspecialchars($tai_khoan); ?></td></tr>
                <tr><th>Mật khẩu</th><td><?php echo strlen($mat_khau); ?> ký tự</td></tr>
                <tr><th>Thời gian</th><td><?php echo date("H:i:s d/m/Y"); ?></td></tr>
            </table>
            <a class="nut" href="project_tich_hop.php">Vào hệ thống Danh bạ</a>
            <a class="nut nut-phu" href="dang_nhap.php">Đăng nhập lại</a>
        <?php } else { ?>
            <h1>Đăng nhập</h1>
            <form method="POST" action="">
                <label for="tai_khoan">Email hoặc Mã sinh viên</label>
                <input type="text" id="tai_khoan" name="tai_khoan" value="<?php echo htmlspecialchars($tai_khoan); ?>" placeholder="Mã SV hoặc Email...">
                <?php if (isset($loi["tai_khoan"])) { ?><p class="loi"><?php echo $loi["tai_khoan"]; ?></p><?php } ?>

                <label for="mat_khau">Mật khẩu</label>
                <input type="password" id="mat_khau" name="mat_khau" placeholder="Nhập mật khẩu...">
                <?php if (isset($loi["mat_khau"])) { ?><p class="loi"><?php echo $loi["mat_khau"]; ?></p><?php } ?>

                <button type="submit" class="nut">Đăng nhập</button>
            </form>
            <p class="chuyen-trang">Chưa có tài khoản? <a href="dang_ky.php">Đăng ký</a></p>
        <?php } ?>
        <p class="chuyen-trang"><a href="index.php">← Trang chủ</a></p>
    </div>
</body>
</html>