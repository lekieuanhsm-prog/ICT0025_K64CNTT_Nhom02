<?php
$host = 'localhost';
$dbname = 'so_dia_chi_danh_ba';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // dùng prepared statement thật của MySQL
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu ($dbname): " . $e->getMessage());
}
?>