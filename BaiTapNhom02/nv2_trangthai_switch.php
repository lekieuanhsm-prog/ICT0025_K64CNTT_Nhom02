<?php
// Sửa giá trị 1, 2 hoặc 9 ở đây
$trangThai = 2;

switch ($trangThai) {
    case 1:
        echo "Trạng thái $trangThai: Mới tạo";
        break;
    case 2:
        echo "Trạng thái $trangThai: Đang xử lý";
        break;
    default:
        echo "Trạng thái $trangThai: Không xác định";
        break;
}
?>