<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 02 - Biến trong PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { border: 1px solid #ccc; padding: 15px; width: 480px; background: #fafafa; border-radius: 5px; }
        .card { background: #fff; border: 1px solid #e0e0e0; padding: 10px; margin-bottom: 12px; border-radius: 4px; }
        label { font-weight: bold; font-size: 13px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 6px; margin: 4px 0 10px; box-sizing: border-box; }
        button { padding: 7px 14px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px; }
        button:hover { background: #0056b3; }
        .badge { background: #e7f3ff; color: #0066cc; padding: 2px 6px; border-radius: 3px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bài 02: Quản lý biến & Thêm liên hệ mới</h2>

        <?php
        // 1. BIẾN NGƯỜI THỨ NHẤT 
        $ho_ten_1 = isset($_GET['ten_1']) && $_GET['ten_1'] != '' ? $_GET['ten_1'] : "Lê Thị Kiều Anh";
        $nhom_1 = isset($_GET['nhom_1']) && $_GET['nhom_1'] != '' ? $_GET['nhom_1'] : "Bạn cùng lớp K64-CNTT A";
        $sdt_1 = isset($_GET['sdt_1']) && $_GET['sdt_1'] != '' ? $_GET['sdt_1'] : "0987654321";
        $so_cuoc_goi_1 = isset($_GET['goi_1']) ? (int)$_GET['goi_1'] : 1;

        // 2. BIẾN NGƯỜI THỨ HAI 
        $ho_ten_2 = isset($_GET['ten_2']) && $_GET['ten_2'] != '' ? $_GET['ten_2'] : "Nguyễn Văn An";
        $nhom_2 = isset($_GET['nhom_2']) && $_GET['nhom_2'] != '' ? $_GET['nhom_2'] : "Bạn thân";
        $sdt_2 = isset($_GET['sdt_2']) && $_GET['sdt_2'] != '' ? $_GET['sdt_2'] : "0912345678";
        $so_cuoc_goi_2 = isset($_GET['goi_2']) ? (int)$_GET['goi_2'] : 0;

        // Tổng số liên hệ và tổng cuộc gọi
        $tong_cuoc_goi = $so_cuoc_goi_1 + $so_cuoc_goi_2;
        ?>

        <!-- HIỂN THỊ DANH SÁCH LIÊN HỆ TỪ CÁC BIẾN -->
        <div class="card">
            <b>Liên hệ 1:</b> <?php echo htmlspecialchars($ho_ten_1); ?> 
            <span class="badge"><?php echo htmlspecialchars($nhom_1); ?></span><br>
            Số điện thoại: <?php echo htmlspecialchars($sdt_1); ?><br>
            Số cuộc gọi: <?php echo $so_cuoc_goi_1; ?> cuộc
        </div>

        <div class="card">
            <b>Liên hệ 2 :</b> <?php echo htmlspecialchars($ho_ten_2); ?> 
            <span class="badge"><?php echo htmlspecialchars($nhom_2); ?></span><br>
            Số điện thoại: <?php echo htmlspecialchars($sdt_2); ?><br>
            Số cuộc gọi: <?php echo $so_cuoc_goi_2; ?> cuộc
        </div>

        <p><i>Tổng số cuộc gọi của cả 2 liên hệ: <b><?php echo $tong_cuoc_goi; ?></b> cuộc</i></p>

        <hr>

        <!-- FORM CẬP NHẬT BIẾN VÀ THÊM THÔNG TIN MỚI -->
        <form method="GET" action="02_bien.php">
            <h4>1. Sửa thông tin liên hệ 1:</h4>
            <label>Họ và tên:</label>
            <input type="text" name="ten_1" value="<?php echo htmlspecialchars($ho_ten_1); ?>">

            <label>Nhóm liên hệ:</label>
            <input type="text" name="nhom_1" value="<?php echo htmlspecialchars($nhom_1); ?>">

            <label>Số điện thoại:</label>
            <input type="text" name="sdt_1" value="<?php echo htmlspecialchars($sdt_1); ?>">

            <label>Số cuộc gọi:</label>
            <input type="number" name="goi_1" value="<?php echo $so_cuoc_goi_1; ?>" min="0">

            <hr style="border-top: 1px dashed #ccc;">

            <h4>2. Thêm / Đổi thông tin bạn thứ 2:</h4>
            <label>Họ và tên bạn mới:</label>
            <input type="text" name="ten_2" value="<?php echo htmlspecialchars($ho_ten_2); ?>">

            <label>Nhóm liên hệ:</label>
            <input type="text" name="nhom_2" value="<?php echo htmlspecialchars($nhom_2); ?>">

            <label>Số điện thoại:</label>
            <input type="text" name="sdt_2" value="<?php echo htmlspecialchars($sdt_2); ?>">

            <label>Số cuộc gọi:</label>
            <input type="number" name="goi_2" value="<?php echo $so_cuoc_goi_2; ?>" min="0">

            <button type="submit">Cập nhật toàn bộ danh bạ</button>
        </form>
    </div>
</body>
</html>
