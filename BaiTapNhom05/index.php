<?php
require_once 'db.php';

$id_sua = 0;
$ho_ten = '';
$so_dien_thoai = '';
$id_nhom = 1;
$loi = '';
$thanh_cong = '';

// 1. XỬ LÝ XÓA LIÊN HỆ (DELETE bằng PREPARE)
if (isset($_GET['delete'])) {
    $id_xoa = (int)$_GET['delete'];
    if ($id_xoa > 0) {
        $stmt = $pdo->prepare("DELETE FROM lien_he WHERE id = :id");
        $stmt->execute([':id' => $id_xoa]);
        $thanh_cong = "Đã xóa liên hệ (ID: $id_xoa) khỏi danh bạ!";
    }
}

// 2. NẠP DỮ LIỆU KHI BẤM NÚT "SỬA" (Lấy bản ghi đưa lên form)
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM lien_he WHERE id = :id");
    $stmt->execute([':id' => $id_edit]);
    $row_edit = $stmt->fetch();
    if ($row_edit) {
        $id_sua        = (int)$row_edit['id'];
        $ho_ten        = $row_edit['ho_ten'];
        $so_dien_thoai = $row_edit['so_dien_thoai'];
        $id_nhom       = (int)$row_edit['id_nhom'];
    }
}

// 3. XỬ LÝ FORM POST: THÊM MỚI (INSERT) HOẶC CẬP NHẬT (UPDATE) BẰNG PREPARE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sua        = (int)($_POST['id_sua'] ?? 0);
    $ho_ten        = trim($_POST['ho_ten'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $id_nhom       = (int)($_POST['id_nhom'] ?? 1);

    // Kiểm tra trường bắt buộc bằng điều kiện if
    if ($ho_ten === '' || $so_dien_thoai === '') {
        $loi = "Vui lòng nhập đầy đủ Họ và tên và Số điện thoại (không được để trống).";
    } else {
        if ($id_sua > 0) {
            // Chế độ CẬP NHẬT (UPDATE kèm WHERE id = :id)
            $sql = "UPDATE lien_he 
                    SET ho_ten = :ho_ten, so_dien_thoai = :sdt, id_nhom = :id_nhom 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':ho_ten'  => $ho_ten,
                ':sdt'     => $so_dien_thoai,
                ':id_nhom' => $id_nhom,
                ':id'      => $id_sua
            ]);
            $thanh_cong = "Đã cập nhật thông tin cho '" . htmlspecialchars($ho_ten, ENT_QUOTES, 'UTF-8') . "'!";
        } else {
            // Chế độ THÊM MỚI (INSERT)
            $sql = "INSERT INTO lien_he (ho_ten, don_vi_lop, so_dien_thoai, id_nhom) 
                    VALUES (:ho_ten, 'K64CNTT', :sdt, :id_nhom)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':ho_ten'  => $ho_ten,
                ':sdt'     => $so_dien_thoai,
                ':id_nhom' => $id_nhom
            ]);
            $thanh_cong = "Đã thêm liên hệ '" . htmlspecialchars($ho_ten, ENT_QUOTES, 'UTF-8') . "' vào danh bạ!";
        }

        // Đặt lại form về trạng thái thêm mới sau khi lưu thành công
        $id_sua = 0;
        $ho_ten = '';
        $so_dien_thoai = '';
        $id_nhom = 1;
    }
}

// 4. Lấy danh sách nhóm cho ô chọn
$ds_nhom = $pdo->query("SELECT id, ten_nhom FROM nhom_lien_he ORDER BY id ASC")->fetchAll();

// 5. Dùng SELECT lấy danh sách liên hệ và nối tên nhóm
$sql_ds = "SELECT lh.id, lh.ho_ten, lh.so_dien_thoai, nh.ten_nhom 
           FROM lien_he lh 
           INNER JOIN nhom_lien_he nh ON lh.id_nhom = nh.id 
           ORDER BY lh.id DESC";
$ds_lien_he = $pdo->query($sql_ds)->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>BTN_05 - Sổ địa chỉ & Danh bạ liên hệ (Nhóm 02)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📒 Hệ thống Sổ địa chỉ – Danh bạ liên hệ trực tuyến</h2>
            <p> Nhóm 02 – K64CNTT</p>
        </div>

        <?php if ($loi !== ''): ?>
            <div class="alert-err"><?= htmlspecialchars($loi, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($thanh_cong !== ''): ?>
            <div class="alert-ok"><?= $thanh_cong ?></div>
        <?php endif; ?>

        <!-- Form Thêm mới / Chỉnh sửa liên hệ (3 trường) -->
        <div class="card <?= $id_sua > 0 ? 'editing' : '' ?>">
            <h3><?= $id_sua > 0 ? "Chỉnh sửa thông tin liên hệ (ID: $id_sua)" : "Thêm liên hệ mới" ?></h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="id_sua" value="<?= $id_sua ?>">
                <div class="grid-3">
                    <div>
                        <label for="ho_ten">Họ và tên (*):</label>
                        <input type="text" id="ho_ten" name="ho_ten" value="<?= htmlspecialchars($ho_ten, ENT_QUOTES, 'UTF-8') ?>" placeholder="VD: Lò Thị Mai">
                    </div>
                    <div>
                        <label for="so_dien_thoai">Số điện thoại (*):</label>
                        <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?= htmlspecialchars($so_dien_thoai, ENT_QUOTES, 'UTF-8') ?>" placeholder="VD: 0987654321">
                    </div>
                    <div>
                        <label for="id_nhom">Nhóm danh bạ:</label>
                        <select id="id_nhom" name="id_nhom">
                            <?php foreach ($ds_nhom as $nhom): ?>
                                <option value="<?= (int)$nhom['id'] ?>" <?= ($id_nhom == $nhom['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nhom['ten_nhom'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if ($id_sua > 0): ?>
                    <button type="submit" class="btn btn-warn">Cập nhật thông tin</button>
                    <a href="index.php" class="btn btn-sec">Hủy sửa</a>
                <?php else: ?>
                    <button type="submit" class="btn">Lưu vào danh bạ</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Bảng hiển thị danh sách liên hệ (SELECT + foreach + htmlspecialchars) -->
        <div class="card">
            <h3>Danh sách liên hệ trong CSDL (<?= count($ds_lien_he) ?> người)</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 7%;">ID</th>
                        <th style="width: 30%;">Họ và tên</th>
                        <th style="width: 22%;">Số điện thoại</th>
                        <th style="width: 23%;">Nhóm danh bạ</th>
                        <th style="width: 18%;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($ds_lien_he) === 0): ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color:#64748b; padding:16px;">
                                Chưa có dữ liệu liên hệ nào trong danh bạ.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ds_lien_he as $item): ?>
                        <tr>
                            <td><?= (int)$item['id'] ?></td>
                            <td><b><?= htmlspecialchars($item['ho_ten'], ENT_QUOTES, 'UTF-8') ?></b></td>
                            <td><?= htmlspecialchars($item['so_dien_thoai'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><span class="badge"><?= htmlspecialchars($item['ten_nhom'], ENT_QUOTES, 'UTF-8') ?></span></td>
                            <td>
                                <a href="index.php?edit=<?= (int)$item['id'] ?>" class="btn btn-warn btn-sm">Sửa</a>
                                <a href="index.php?delete=<?= (int)$item['id'] ?>" class="btn btn-del btn-sm" onclick="return confirm('Bạn có chắc muốn xóa liên hệ này không?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>