<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 03 - Hằng số PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { border: 1px solid #ccc; padding: 15px; width: 450px; background: #fafafa; border-radius: 5px; }
        select, button { padding: 6px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bài 03: Hằng số & Phí lưu trữ danh bạ</h2>

        <?php
        // Khai báo hằng bằng define và const
        define("TEN_DICH_VU", "Lưu trữ danh bạ Cloud");
        const PHI_CO_DINH = 10000; // 10.000 VNĐ / tháng
        const GIOI_HAN_LIEN_HE = 500; // Tối đa 500 số

        // Biến số tháng đăng ký
        $so_thang = isset($_GET['thang']) ? (int)$_GET['thang'] : 3;
        $tong_tien = $so_thang * PHI_CO_DINH;

        echo "<p>Dịch vụ: <b>" . TEN_DICH_VU . "</b></p>";
        echo "<p>Giới hạn liên hệ : <b>" . GIOI_HAN_LIEN_HE . " liên hệ</b></p>";
        echo "<p>Giá mỗi tháng : <b>" . number_format(PHI_CO_DINH) . " VNĐ</b></p>";
        echo "<p>Số tháng chọn mua: <b>" . $so_thang . " tháng</b></p>";
        echo "<p style='color:red;'><b>Tổng chi phí: " . number_format($tong_tien) . " VNĐ</b></p>";
        ?>

        <hr>
        <!-- Chức năng mới: Chọn số tháng gia hạn để tính lại tiền theo hằng số -->
        <form method="GET" action="03_hang.php">
            <label>Chọn gói gia hạn:</label>
            <select name="thang">
                <option value="1" <?php if($so_thang==1) echo 'selected'; ?>>1 tháng</option>
                <option value="3" <?php if($so_thang==3) echo 'selected'; ?>>3 tháng</option>
                <option value="6" <?php if($so_thang==6) echo 'selected'; ?>>6 tháng</option>
                <option value="12" <?php if($so_thang==12) echo 'selected'; ?>>12 tháng</option>
            </select>
            <button type="submit">Tính phí</button>
        </form>
    </div>
</body>
</html>