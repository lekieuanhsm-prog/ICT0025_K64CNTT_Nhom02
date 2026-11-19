<?php
// Hàm dùng chung: session, kết nối CSDL, đăng nhập, CSRF, escape...
session_start();
require_once __DIR__ . '/db.php';

const LOAI_QUAN_HE = ['Gia đình', 'Họ hàng', 'Bạn bè', 'Bạn học', 'Đồng nghiệp', 'Hàng xóm', 'Người yêu/Vợ chồng', 'Khác'];
const GIOI_TINH    = ['Nam', 'Nữ', 'Khác'];

// Escape trước khi in ra HTML (chống XSS)
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Chuyển trang, có thể kèm thông báo (loại: 'ok' hoặc 'err')
function chuyen_huong(string $url, string $loai = '', string $nd = ''): void {
    if ($nd !== '') { $_SESSION['flash'] = [$loai, $nd]; }
    header("Location: $url");
    exit;
}

// Bắt buộc đăng nhập, trả về id người dùng hiện tại
function yeu_cau_dang_nhap(): int {
    if (empty($_SESSION['uid'])) { chuyen_huong('login.php'); }
    return (int)$_SESSION['uid'];
}

// Mã chống CSRF cho các form POST
function csrf(): string {
    if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(16)); }
    return $_SESSION['csrf'];
}
function kiem_tra_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('Yêu cầu không hợp lệ (sai mã bảo vệ). Hãy quay lại và tải lại trang.');
    }
}

function hop_le_sdt(string $s): bool { return (bool)preg_match('/^(0|\+84)[0-9]{9,10}$/', $s); }

// Chữ cái đầu của tên (cho ảnh đại diện)
function chu_cai(string $ten): string {
    $p = preg_split('/\s+/', trim($ten));
    return mb_strtoupper(mb_substr(end($p), 0, 1));
}

function tuoi(?string $ngay_sinh): ?int {
    return $ngay_sinh ? (new DateTime($ngay_sinh))->diff(new DateTime())->y : null;
}

// Lấy 1 liên hệ CỦA NGƯỜI DÙNG HIỆN TẠI (không xem được liên hệ của người khác)
function lay_lien_he(PDO $pdo, int $id, int $uid) {
    $st = $pdo->prepare("SELECT lh.*, nh.ten_nhom FROM lien_he lh
                         LEFT JOIN nhom_lien_he nh ON nh.id = lh.id_nhom
                         WHERE lh.id = :id AND lh.id_nguoi_dung = :u");
    $st->execute([':id' => $id, ':u' => $uid]);
    return $st->fetch();
}

function lay_nhom(PDO $pdo, int $uid): array {
    $st = $pdo->prepare("SELECT id, ten_nhom FROM nhom_lien_he WHERE id_nguoi_dung = :u ORDER BY ten_nhom");
    $st->execute([':u' => $uid]);
    return $st->fetchAll();
}
