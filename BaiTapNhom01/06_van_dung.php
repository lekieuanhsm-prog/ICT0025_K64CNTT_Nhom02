<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 06 - Vận dụng tính hóa đơn</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { border: 1px solid #ccc; padding: 18px; width: 460px; background: #fafafa; border-radius: 5px; }
        .card-bill { background: #fff; border: 1px solid #e0e0e0; padding: 12px; border-radius: 4px; margin-bottom: 12px; line-height: 1.6; }
        .row { margin-bottom: 10px; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 6px; box-sizing: border-box; margin-top: 3px; }
        button { padding: 7px 15px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px; }
        button:hover { background: #0056b3; }
        .total { color: #d9534f; font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bài 06: Đặt mua Thẻ Danh bạ NFC</h2>

        <?php
        // 1. Khai báo hằng số tỷ lệ phí dịch vụ (5%)
        define("TY_LE_PHI", 0.05);

        // 2. Tiếp nhận dữ liệu từ form (mặc định theo bộ đối chiếu chuẩn)
        $ten_hang = isset($_GET['ten_hang']) && $_GET['ten_hang'] !== '' ? $_GET['ten_hang'] : "Thẻ danh bạ NFC";
        $so_luong = isset($_GET['so_luong']) ? (int)$_GET['so_luong'] : 3;
        $don_gia  = isset($_GET['don_gia']) ? (float)$_GET['don_gia'] : 25000;

        if ($so_luong < 1) $so_luong = 1;

        // 3. Tính toán theo biểu thức có dấu ngoặc rõ ràng
        $tien_hang = ($so_luong * $don_gia);
        $tien_phi  = ($tien_hang * TY_LE_PHI);
        $tong_tien = ($tien_hang + $tien_phi);
        ?>

        <!-- BẢNG HÓA ĐƠN GỌN GÀNG, DỄ NHÌN -->
        <div class="card-bill">
            <b>HÓA ĐƠN THANH TOÁN:</b><br>
            &bull; Mặt hàng: <b><?php echo htmlspecialchars($ten_hang); ?></b><br>
            &bull; Số lượng: <?php echo $so_luong; ?> cái<br>
            &bull; Đơn giá: <?php echo number_format($don_gia, 0, ',', '.'); ?> VNĐ<br>
            &bull; Phí dịch vụ (hằng số): <?php echo (TY_LE_PHI * 100); ?>%<br>
            &bull; Tiền hàng: <?php echo number_format($tien_hang, 0, ',', '.'); ?> VNĐ<br>
            &bull; Tiền phí: <?php echo number_format($tien_phi, 0, ',', '.'); ?> VNĐ<br>
            <hr style="border: none; border-top: 1px dashed #ccc; margin: 8px 0;">
            &bull; <span class="total">Tổng thanh toán: <?php echo number_format($tong_tien, 0, ',', '.'); ?> VNĐ</span>
        </div>

        <hr>

        <!-- FORM TƯƠNG TÁC: ĐỔI SỐ LƯỢNG VÀ ĐƠN GIÁ TỰ TÍNH -->
        <form method="GET" action="06_van_dung.php">
            <div class="row">
                <label>Tên mặt hàng:</label>
                <input type="text" name="ten_hang" value="<?php echo htmlspecialchars($ten_hang); ?>">
            </div>

            <div class="row">
                <label>Số lượng:</label>
                <input type="number" name="so_luong" value="<?php echo $so_luong; ?>" min="1">
            </div>

            <div class="row">
                <label>Đơn giá (VNĐ):</label>
                <input type="number" name="don_gia" value="<?php echo $don_gia; ?>" step="1000">
            </div>

            <button type="submit">Tính lại tiền</button>
        </form>

        <!-- ĐƯỜNG DẪN THỬ NHANH 2 BỘ DỮ LIỆU ĐỐI CHIẾU -->
        <p style="font-size: 13px; color: #555; margin-top: 15px;">
            <b>Thử nhanh 2 bộ dữ liệu:</b><br>
            &bull; <a href="06_van_dung.php?ten_hang=Thẻ+danh+bạ+NFC&so_luong=3&don_gia=25000">Bộ 1 (3 x 25.000 đ &rarr; 78.750 đ)</a><br>
            &bull; <a href="06_van_dung.php?ten_hang=Thẻ+NFC+VIP+Kim+loại&so_luong=10&don_gia=80000">Bộ 2 (10 x 80.000 đ &rarr; 840.000 đ)</a>
        </p>
    </div>
</body>
</html>
