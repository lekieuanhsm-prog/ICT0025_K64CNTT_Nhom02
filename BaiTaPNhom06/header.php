<?php $tieu_de = $tieu_de ?? 'Danh bạ'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($tieu_de) ?> – Sổ địa chỉ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="nav">
    <a class="brand" href="index.php">📒 Sổ địa chỉ</a>
    <?php if (!empty($_SESSION['uid'])): ?>
        <a href="index.php">Danh bạ</a>
        <a href="contact_form.php">+ Thêm liên hệ</a>
        <a href="groups.php">Nhóm</a>
        <span class="grow"></span>
        <span>👤 <?= e($_SESSION['ten']) ?></span>
        <a href="logout.php">Đăng xuất</a>
    <?php endif; ?>
</nav>
<main class="container">
<?php if (isset($_SESSION['flash'])): [$fl_loai, $fl_nd] = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div class="alert alert-<?= e($fl_loai) ?>"><?= e($fl_nd) ?></div>
<?php endif; ?>
