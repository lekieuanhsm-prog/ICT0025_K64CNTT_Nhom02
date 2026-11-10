<?php
// Mảng danh bạ ban đầu
$danhSach = [
    ['ma_sv' => '231031001', 'ho_ten' => 'Lê Thị Kiều Anh', 'lop' => 'K64CNTT', 'nam_sinh' => 2005, 'sdt' => '0981234567'],
    ['ma_sv' => '231031002', 'ho_ten' => 'Phin Sạ Vẳn',    'lop' => 'K64CNTT', 'nam_sinh' => 2004, 'sdt' => '0978901234'],
    ['ma_sv' => '231031003', 'ho_ten' => 'Bùi Quang Huy',    'lop' => 'K64CNTT', 'nam_sinh' => 2005, 'sdt' => '0965432198'],
    ['ma_sv' => '231031004', 'ho_ten' => 'Seng su Li',      'lop' => 'K64CNTT', 'nam_sinh' => 2004, 'sdt' => '0912348765'],
];

// 1. Thêm mới sinh viên bằng POST
$thongBao = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'them') {
    $ma = trim($_POST['ma_sv'] ?? '');
    $ten = trim($_POST['ho_ten'] ?? '');
    $lop = trim($_POST['lop'] ?? '');
    $nam = (int)($_POST['nam_sinh'] ?? 2005);
    $sdt = trim($_POST['sdt'] ?? '');

    if ($ma !== '' && $ten !== '' && $sdt !== '') {
        $danhSach[] = ['ma_sv' => $ma, 'ho_ten' => $ten, 'lop' => $lop, 'nam_sinh' => $nam, 'sdt' => $sdt];
        $thongBao = "Đã thêm sinh viên: " . htmlspecialchars($ten);
    }
}

// 2. Tìm kiếm sinh viên bằng GET
$tuKhoa = trim($_GET['tu_khoa'] ?? '');
$ketQua = [];
foreach ($danhSach as $sv) {
    if ($tuKhoa === '' || stripos($sv['ho_ten'], $tuKhoa) !== false || stripos($sv['ma_sv'], $tuKhoa) !== false) {
        $ketQua[] = $sv;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sổ danh bạ sinh viên</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 25px; background: #f1f5f9; }
        .khung-lon { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th { background: #f8fafc; }
        input { padding: 7px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { padding: 7px 15px; background: #6a82fb; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .chia-cot { display: flex; gap: 20px; margin-top: 15px; }
        .cot-trai { flex: 1; background: #fafafa; padding: 15px; border-radius: 6px; }
        .cot-phai { flex: 2; }
    </style>
</head>
<body>
    <div class="khung-lon">
        <p><a href="index.php" style="color:#6a82fb; text-decoration:none;">← Trang chủ</a> | <a href="dang_ky.php" style="color:#6a82fb; text-decoration:none;">Đăng ký</a></p>
        <h2>Sổ địa chỉ & Danh bạ Sinh viên (Nhóm 02)</h2>

        <!-- Form tìm kiếm (GET) -->
        <form method="GET" style="display:flex; gap:10px;">
            <input type="text" name="tu_khoa" value="<?php echo htmlspecialchars($tuKhoa); ?>" placeholder="Tìm kiếm theo tên hoặc mã SV..." style="flex:1;">
            <button type="submit">Tìm (GET)</button>
            <?php if ($tuKhoa !== ''): ?><a href="project_tich_hop.php" style="line-height:32px; color:red; text-decoration:none;">Xóa tìm</a><?php endif; ?>
        </form>

        <?php if ($thongBao): ?><p style="color:green; margin:10px 0;"><?php echo $thongBao; ?></p><?php endif; ?>

        <div class="chia-cot">
            <!-- Form thêm sinh viên (POST) -->
            <div class="cot-trai">
                <h4 style="margin-top:0;">Thêm sinh viên mới (POST)</h4>
                <form method="POST">
                    <input type="hidden" name="action" value="them">
                    <p style="margin:6px 0;"><label>Mã SV: <input type="text" name="ma_sv" required style="width:100%;"></label></p>
                    <p style="margin:6px 0;"><label>Họ tên: <input type="text" name="ho_ten" required style="width:100%;"></label></p>
                    <p style="margin:6px 0;"><label>Lớp: <input type="text" name="lop" value="K64CNTT" required style="width:100%;"></label></p>
                    <p style="margin:6px 0;"><label>Năm sinh: <input type="number" name="nam_sinh" value="2005" required style="width:100%;"></label></p>
                    <p style="margin:6px 0;"><label>Số điện thoại: <input type="text" name="sdt" required style="width:100%;"></label></p>
                    <button type="submit" style="width:100%; margin-top:8px;">Lưu vào danh bạ</button>
                </form>
            </div>

            <!-- Bảng danh sách sinh viên -->
            <div class="cot-phai">
                <h4 style="margin-top:0;">Danh sách sinh viên (<?php echo count($ketQua); ?>)</h4>
                <table>
                    <tr><th>Mã SV</th><th>Họ tên</th><th>Lớp</th><th>Tuổi</th><th>Số điện thoại</th></tr>
                    <?php foreach ($ketQua as $item): ?>
                    <tr>
                        <td><b><?php echo htmlspecialchars($item['ma_sv']); ?></b></td>
                        <td><?php echo htmlspecialchars($item['ho_ten']); ?></td>
                        <td><?php echo htmlspecialchars($item['lop']); ?></td>
                        <td><?php echo date('Y') - (int)$item['nam_sinh']; ?></td>
                        <td><?php echo htmlspecialchars($item['sdt']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>