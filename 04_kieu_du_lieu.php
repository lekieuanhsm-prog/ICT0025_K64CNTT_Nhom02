<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 04 - Kiểu dữ liệu</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { border: 1px solid #ccc; padding: 15px; width: 450px; background: #fafafa; border-radius: 5px; }
        .card-info { background: #fff; border: 1px solid #e0e0e0; padding: 12px; border-radius: 4px; margin-bottom: 12px; }
        .debug-box { background: #f0f0f0; border-left: 3px solid #888; padding: 8px 10px; font-size: 13px; color: #444; margin: 12px 0; }
        input[type="text"], select { padding: 5px; margin: 3px 0 10px; width: 100%; box-sizing: border-box; }
        button { padding: 6px 12px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bài 04: Thông tin liên hệ & Kiểu dữ liệu</h2>

        <?php
        // 1. Nhận dữ liệu nhập từ form (hoặc lấy mặc định)
        $ten_lien_he = isset($_GET['ten']) && $_GET['ten'] !== '' ? $_GET['ten'] : "Nguyễn Văn An";
        $nam_sinh_raw = isset($_GET['nam_sinh']) ? $_GET['nam_sinh'] : "2004";
        $diem_danh_gia_raw = isset($_GET['danh_gia']) ? $_GET['danh_gia'] : "4.8";
        $la_ban_than_raw = isset($_GET['ban_than']) ? $_GET['ban_than'] : "1";
        $ghi_chu = null;

        // 2. Ép kiểu dữ liệu
        $nam_sinh = (int)$nam_sinh_raw;             // chuỗi sang int
        $diem_danh_gia = (float)$diem_danh_gia_raw; // chuỗi sang float
        $la_ban_than = (bool)$la_ban_than_raw;     // sang bool
        ?>

        <!-- HIỂN THỊ ĐẸP MẮT NHƯ DANH BẠ THẬT (KHÔNG BỊ CHỮ INT/FLOAT ĐÈ VÀO) -->
        <div class="card-info">
            <b>Họ và tên:</b> <?php echo htmlspecialchars($ten_lien_he); ?><br>
            <b>Năm sinh:</b> <?php echo $nam_sinh; ?> (<?php echo (2026 - $nam_sinh); ?> tuổi)<br>
            <b>Đánh giá:</b> <?php echo $diem_danh_gia; ?> / 5 sao<br>
            <b>Mối quan hệ:</b> <?php echo $la_ban_than ? "Bạn thân" : "Người quen"; ?><br>
            <b>Ghi chú:</b> <?php echo $ghi_chu ?? "Không có"; ?>
        </div>

        <!-- PHẦN VAR_DUMP GỌN GÀNG ĐỂ ĐỐI CHIẾU KIỂU DỮ LIỆU ĐÚNG ĐỀ BÀI -->
        <div class="debug-box">
            <b>Kiểu dữ liệu ghi nhận (var_dump):</b><br>
            - Tên: <?php var_dump($ten_lien_he); ?><br>
            - Năm sinh: <?php var_dump($nam_sinh); ?><br>
            - Đánh giá: <?php var_dump($diem_danh_gia); ?><br>
            - Bạn thân: <?php var_dump($la_ban_than); ?><br>
            - Ghi chú: <?php var_dump($ghi_chu); ?>
        </div>

        <hr>
        <!-- FORM ĐỔI THÔNG TIN VÀ TỰ ĐỘNG ÉP KIỂU -->
        <form method="GET" action="04_kieu_du_lieu.php">
            <label>Họ và tên (string):</label>
            <input type="text" name="ten" value="<?php echo htmlspecialchars($ten_lien_he); ?>">

            <label>Năm sinh (chuỗi &rarr; ép sang int):</label>
            <input type="text" name="nam_sinh" value="<?php echo htmlspecialchars($nam_sinh_raw); ?>">

            <label>Đánh giá sao (chuỗi &rarr; ép sang float):</label>
            <input type="text" name="danh_gia" value="<?php echo htmlspecialchars($diem_danh_gia_raw); ?>">

            <label>Mối quan hệ (ép sang bool):</label>
            <select name="ban_than">
                <option value="1" <?php if($la_ban_than_raw == "1") echo 'selected'; ?>>Bạn thân (true)</option>
                <option value="0" <?php if($la_ban_than_raw == "0") echo 'selected'; ?>>Người quen (false)</option>
            </select>

            <button type="submit">Lưu & Đổi kiểu</button>
        </form>
    </div>
</body>
</html>