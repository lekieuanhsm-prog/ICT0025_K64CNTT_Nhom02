<?php
// Sửa giá trị 1, 2 hoặc 9 ở đây
$trangThai = 1;

if ($trangThai === 1) {
    echo "Trạng thái $trangThai: Mới tạo";
} elseif ($trangThai === 2) {
    echo "Trạng thái $trangThai: Đang xử lý";
} else {
    echo "Trạng thái $trangThai: Không xác định";
}
?>