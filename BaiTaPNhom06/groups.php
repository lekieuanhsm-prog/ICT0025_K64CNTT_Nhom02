<?php
require_once 'functions.php';
$uid = yeu_cau_dang_nhap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kiem_tra_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    $tb = ['err', 'Thao tác không hợp lệ.'];

    if ($action === 'luu') {
        $ten = trim($_POST['ten_nhom'] ?? '');
        $mo_ta = trim($_POST['mo_ta'] ?? '');
        if ($ten === '' || mb_strlen($ten) > 60) {
            $tb = ['err', 'Tên nhóm không được trống và tối đa 60 ký tự.'];
        } elseif (mb_strlen($mo_ta) > 255) {
            $tb = ['err', 'Mô tả tối đa 255 ký tự.'];
        } else {
            try {
                if ($id > 0) {
                    $st = $pdo->prepare("UPDATE nhom_lien_he SET ten_nhom = :t, mo_ta = :m WHERE id = :id AND id_nguoi_dung = :u");
                    $st->execute([':t' => $ten, ':m' => $mo_ta ?: null, ':id' => $id, ':u' => $uid]);
                    $tb = ['ok', "Đã cập nhật nhóm '$ten'."];
                } else {
                    $st = $pdo->prepare("INSERT INTO nhom_lien_he (id_nguoi_dung, ten_nhom, mo_ta) VALUES (:u, :t, :m)");
                    $st->execute([':u' => $uid, ':t' => $ten, ':m' => $mo_ta ?: null]);
                    $tb = ['ok', "Đã thêm nhóm '$ten'."];
                }
            } catch (PDOException $ex) {
                $tb = ['err', $ex->getCode() === '23000' ? "Nhóm '$ten' đã tồn tại." : 'Lỗi cơ sở dữ liệu: ' . $ex->getMessage()];
            }
        }
    } elseif ($action === 'xoa') {
        $st = $pdo->prepare("SELECT ten_nhom, (SELECT COUNT(*) FROM lien_he WHERE id_nhom = :id1) AS so_lh
                             FROM nhom_lien_he WHERE id = :id2 AND id_nguoi_dung = :u");
        $st->execute([':id1' => $id, ':id2' => $id, ':u' => $uid]);
        $g = $st->fetch();
        if (!$g) {
            $tb = ['err', "Không tìm thấy nhóm có ID = $id."];
        } elseif ($g['so_lh'] > 0) {
            // Có dữ liệu liên quan → không xóa, báo rõ lý do
            $tb = ['err', "Không thể xóa nhóm '{$g['ten_nhom']}' vì còn {$g['so_lh']} liên hệ thuộc nhóm này. Hãy chuyển họ sang nhóm khác trước."];
        } else {
            try {
                $st = $pdo->prepare("DELETE FROM nhom_lien_he WHERE id = :id AND id_nguoi_dung = :u");
                $st->execute([':id' => $id, ':u' => $uid]);
                $tb = $st->rowCount() === 1 ? ['ok', "Đã xóa nhóm '{$g['ten_nhom']}'."] : ['err', 'Không có nhóm nào bị xóa.'];
            } catch (PDOException $ex) {
                $tb = ['err', 'Không thể xóa nhóm: ' . $ex->getMessage()];
            }
        }
    }
    chuyen_huong('groups.php', $tb[0], $tb[1]);
}

// Nạp nhóm cần sửa lên form
$sua = ['id' => 0, 'ten_nhom' => '', 'mo_ta' => ''];
if (isset($_GET['sua'])) {
    $st = $pdo->prepare("SELECT id, ten_nhom, mo_ta FROM nhom_lien_he WHERE id = :id AND id_nguoi_dung = :u");
    $st->execute([':id' => (int)$_GET['sua'], ':u' => $uid]);
    $row = $st->fetch();
    if ($row) { $sua = ['id' => (int)$row['id'], 'ten_nhom' => $row['ten_nhom'], 'mo_ta' => (string)$row['mo_ta']]; }
    else { chuyen_huong('groups.php', 'err', 'Không tìm thấy nhóm cần sửa.'); }
}

$st = $pdo->prepare("SELECT nh.*, (SELECT COUNT(*) FROM lien_he lh WHERE lh.id_nhom = nh.id) AS so_lh
                     FROM nhom_lien_he nh WHERE nh.id_nguoi_dung = :u ORDER BY nh.ten_nhom");
$st->execute([':u' => $uid]);
$ds = $st->fetchAll();

$tieu_de = 'Nhóm liên hệ';
include 'header.php';
?>
<div class="card <?= $sua['id'] ? 'editing' : '' ?>">
    <h3><?= $sua['id'] ? 'Sửa nhóm' : 'Thêm nhóm mới' ?></h3>
    <form method="POST" class="filter">
        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
        <input type="hidden" name="action" value="luu">
        <input type="hidden" name="id" value="<?= $sua['id'] ?>">
        <input type="text" name="ten_nhom" maxlength="60" placeholder="Tên nhóm (*)" value="<?= e($sua['ten_nhom']) ?>">
        <input type="text" name="mo_ta" maxlength="255" placeholder="Mô tả" value="<?= e($sua['mo_ta']) ?>">
        <button class="btn <?= $sua['id'] ? 'btn-warn' : '' ?>"><?= $sua['id'] ? 'Cập nhật' : 'Thêm nhóm' ?></button>
        <?php if ($sua['id']): ?><a class="btn btn-sec" href="groups.php">Hủy</a><?php endif; ?>
    </form>
</div>

<div class="card">
    <h3>Nhóm liên hệ (<?= count($ds) ?>)</h3>
    <div class="table-wrap">
    <table>
        <thead><tr><th>Tên nhóm</th><th>Mô tả</th><th>Số liên hệ</th><th>Thao tác</th></tr></thead>
        <tbody>
        <?php if (!$ds): ?><tr><td colspan="4" class="center muted">Chưa có nhóm nào.</td></tr><?php endif; ?>
        <?php foreach ($ds as $g): ?>
            <tr>
                <td><span class="badge"><?= e($g['ten_nhom']) ?></span></td>
                <td><?= e($g['mo_ta'] ?? '') ?></td>
                <td><a href="index.php?nhom=<?= (int)$g['id'] ?>"><?= (int)$g['so_lh'] ?> người</a></td>
                <td>
                    <a class="btn btn-warn btn-sm" href="groups.php?sua=<?= (int)$g['id'] ?>">Sửa</a>
                    <form method="POST" class="inline-form" onsubmit="return confirm('Xóa nhóm này?');">
                        <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
                        <input type="hidden" name="action" value="xoa">
                        <input type="hidden" name="id" value="<?= (int)$g['id'] ?>">
                        <button class="btn btn-del btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'footer.php'; ?>
