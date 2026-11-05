<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 05 - Toán tử</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { border: 1px solid #ccc; padding: 18px; width: 460px; background: #fafafa; border-radius: 5px; }
        .card-calc { background: #fff; border: 1px solid #e0e0e0; padding: 12px; border-radius: 4px; margin-bottom: 12px; line-height: 1.6; }
        .debug-box { background: #f0f0f0; border-left: 3px solid #888; padding: 8px 10px; font-size: 13px; color: #444; margin: 12px 0; }
        input[type="number"] { width: 80px; padding: 5px; }
        button { padding: 6px 14px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bài 05: Phép toán số học & So sánh == vs ===</h2>

        <?php
        $a = isset($_GET['a']) ? (int)$_GET['a'] : 15;
        $b = isset($_GET['b']) ? (int)$_GET['b'] : 4;
        if ($b == 0) $b = 1; // Chống chia cho 0

        // Phép gán kết hợp
        $dem = $a;
        $dem += 5;

        // So sánh
        $so_sanh_long = (5 == "5");
        $so_sanh_chat = (5 === "5");

        // Logic danh bạ
        $co_trong_danh_ba = true;
        $so_lan_goi = 5;
        $la_lien_he_thuong_xuyen = $co_trong_danh_ba && ($so_lan_goi >= 3);
        ?>

        <!-- PHẦN HIỂN THỊ KẾT QUẢ RÕ RÀNG, DỄ NHÌN -->
        <div class="card-calc">
            <b>1. Phép toán số học (a = <?php echo $a; ?>, b = <?php echo $b; ?>):</b><br>
            &bull; Cộng: <?php echo "$a + $b = " . ($a + $b); ?><br>
            &bull; Trừ: <?php echo "$a - $b = " . ($a - $b); ?><br>
            &bull; Nhân: <?php echo "$a * $b = " . ($a * $b); ?><br>
            &bull; Chia: <?php echo "$a / $b = " . round($a / $b, 2); ?><br>
            &bull; Chia dư: <?php echo "$a % $b = " . ($a % $b); ?><br><br>

            <b>2. Phép gán kết hợp:</b><br>
            Ban đầu x = <?php echo $a; ?>, sau khi <code>$x += 5</code> thì x = <b><?php echo $dem; ?></b><br><br>

            <b>3. Kết quả so sánh & logic:</b><br>
            &bull; So sánh <code>5 == "5"</code>: <b><?php echo $so_sanh_long ? "Đúng (Bằng giá trị)" : "Sai"; ?></b><br>
            &bull; So sánh <code>5 === "5"</code>: <b><?php echo $so_sanh_chat ? "Đúng" : "Sai (Khác kiểu dữ liệu)"; ?></b><br>
            &bull; Liên hệ thường xuyên (Có trong danh bạ VÀ gọi &ge; 3 lần): <b><?php echo $la_lien_he_thuong_xuyen ? "Đạt điều kiện" : "Không đạt"; ?></b>
        </div>

        <!-- PHẦN VAR_DUMP GỌN GÀNG ĐỂ GIẢNG VIÊN ĐỐI CHIẾU TIÊU CHÍ CHẤM -->
        <div class="debug-box">
            <b>Kiểu dữ liệu thực tế (var_dump):</b><br>
            - var_dump(5 == "5"): <?php var_dump($so_sanh_long); ?><br>
            - var_dump(5 === "5"): <?php var_dump($so_sanh_chat); ?><br>
            - var_dump(logic &&): <?php var_dump($la_lien_he_thuong_xuyen); ?>
        </div>

        <hr>
        <!-- FORM ĐỔI SỐ A VÀ B -->
        <form method="GET" action="05_toan_tu.php">
            <label>Số a:</label>
            <input type="number" name="a" value="<?php echo $a; ?>">
            
            <label style="margin-left: 10px;">Số b:</label>
            <input type="number" name="b" value="<?php echo $b; ?>">

            <button type="submit" style="margin-left: 10px;">Tính lại</button>
        </form>
    </div>
</body>
</html>
