<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 01 - Cú pháp PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { border: 1px solid #ccc; padding: 15px; width: 450px; background: #fafafa; border-radius: 5px; }
        input[type="text"] { padding: 5px; width: 200px; }
        button { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bài 01: Cú pháp cơ bản & Lời chào động</h2>
        
        <?php
        $ten_nguoi_xem = isset($_GET['ten']) && $_GET['ten'] != '' ? $_GET['ten'] : "Bạn";
        
        echo "<p>Xin chào <b>" . htmlspecialchars($ten_nguoi_xem) . "</b>! Chào mừng bạn đến với Danh bạ K64-CNTT A.</p>";
        echo "<p>Hôm nay là: " . date("d/m/Y") . "</p>";
        ?>

        <!-- Chức năng mới: Nhập tên để đổi lời chào -->
        <form method="GET" action="01_cu_phap.php">
            <label>Nhập tên của bạn:</label>
            <input type="text" name="ten" placeholder="Ví dụ: Kiều Anh">
            <button type="submit">Gửi</button>
        </form>
    </div>
</body>
</html>