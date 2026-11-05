<?php
// Sửa các biến kiểm thử ở đây:
$trangThai = 2; // Thử với 1, 2 hoặc 9
$soLuong = 3;   // Thử với 0, 1 hoặc 5

echo "<h3>HỆ THỐNG SỔ ĐỊA CHỈ - DANH BẠ LIÊN HỆ</h3>";

// 1. Nhãn trạng thái (switch)
switch ($trangThai) {
    case 1:
        echo "Trạng thái đồng bộ: Mới tạo <br><br>";
        break;
    case 2:
        echo "Trạng thái đồng bộ: Đang xử lý <br><br>";
        break;
    default:
        echo "Trạng thái đồng bộ: Không xác định <br><br>";
        break;
}

// 2. Danh sách công việc (for)
echo "<b>Danh sách công việc gần đây ($soLuong việc):</b><br>";
for ($i = 1; $i <= $soLuong; $i++) {
    echo "Công việc $i: Kiểm tra số liên hệ $i <br>";
}
?>