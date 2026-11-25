-- =================================================================
-- CƠ SỞ DỮ LIỆU: HỆ THỐNG SỔ ĐỊA CHỈ – DANH BẠ LIÊN HỆ TRỰC TUYẾN
-- Học phần: Lập trình ứng dụng Web (ICT0025) - Lớp K64CNTT
-- Nhóm thực hiện: Nhóm 02
-- =================================================================

SET NAMES utf8mb4;
SET time_zone = "+07:00";

-- Lưu ý: Tạo hoặc chọn CSDL `so_dia_chi_danh_ba` (utf8mb4_unicode_ci) trước khi Import.
-- Không chứa lệnh DROP DATABASE theo đúng quy định nộp bài thiết kế.

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `quan_he`, `lien_he`, `nhom_lien_he`, `nguoi_dung`;
SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------
-- 1. Bảng `nguoi_dung`: Tài khoản người sử dụng sổ danh bạ
-- -----------------------------------------------------------------
CREATE TABLE `nguoi_dung` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ho_ten` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mat_khau` VARCHAR(255) NOT NULL COMMENT 'Mã hóa bằng password_hash()',
  `ngay_tao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------
-- 2. Bảng `nhom_lien_he`: Phân loại nhóm danh bạ của từng người dùng
-- -----------------------------------------------------------------
CREATE TABLE `nhom_lien_he` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_nguoi_dung` INT NOT NULL,
  `ten_nhom` VARCHAR(60) NOT NULL,
  `mo_ta` VARCHAR(255) NULL,
  UNIQUE KEY `uq_nhom` (`id_nguoi_dung`, `ten_nhom`),
  CONSTRAINT `fk_nhom_nd` FOREIGN KEY (`id_nguoi_dung`)
    REFERENCES `nguoi_dung`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------
-- 3. Bảng `lien_he`: Hồ sơ thông tin các liên hệ trong danh bạ
-- -----------------------------------------------------------------
CREATE TABLE `lien_he` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_nguoi_dung` INT NOT NULL,
  `id_nhom` INT NULL COMMENT 'NULL = chưa phân nhóm',
  `ho_ten` VARCHAR(100) NOT NULL,
  `gioi_tinh` ENUM('Nam','Nữ','Khác') NOT NULL DEFAULT 'Khác',
  `ngay_sinh` DATE NULL,
  `so_dien_thoai` VARCHAR(15) NOT NULL,
  `email` VARCHAR(100) NULL,
  `don_vi` VARCHAR(100) NULL COMMENT 'Lớp / cơ quan / công ty',
  `dia_chi` VARCHAR(255) NULL,
  `ghi_chu` TEXT NULL,
  `yeu_thich` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1: Yêu thích, 0: Bình thường',
  `ngay_tao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_ten` (`ho_ten`),
  KEY `idx_sdt` (`so_dien_thoai`),
  CONSTRAINT `fk_lh_nd` FOREIGN KEY (`id_nguoi_dung`)
    REFERENCES `nguoi_dung`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lh_nhom` FOREIGN KEY (`id_nhom`)
    REFERENCES `nhom_lien_he`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------
-- 4. Bảng `quan_he`: Kết nối mối quan hệ giữa hai liên hệ (N - N tự tham chiếu)
-- -----------------------------------------------------------------
CREATE TABLE `quan_he` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_lien_he_a` INT NOT NULL,
  `id_lien_he_b` INT NOT NULL,
  `loai` VARCHAR(30) NOT NULL,
  `ghi_chu` VARCHAR(150) NULL,
  UNIQUE KEY `uq_cap` (`id_lien_he_a`, `id_lien_he_b`),
  CONSTRAINT `ck_a_nho_hon_b` CHECK (`id_lien_he_a` < `id_lien_he_b`),
  CONSTRAINT `fk_qh_a` FOREIGN KEY (`id_lien_he_a`)
    REFERENCES `lien_he`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_qh_b` FOREIGN KEY (`id_lien_he_b`)
    REFERENCES `lien_he`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- DỮ LIỆU GIẢ LẬP KIỂM THỬ (DUMMY DATA - KHÔNG DÙNG DỮ LIỆU THẬT)
-- =================================================================

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`) VALUES
(1, 'Tài khoản Dùng thử 01', 'demo1@example.com', '$2y$12$Ou48QGg7WbNRZtn.5/I76u5rLyfXcfwH37NgHPzHF70TnEmc/sQtK'),
(2, 'Tài khoản Dùng thử 02', 'demo2@example.com', '$2y$12$Ou48QGg7WbNRZtn.5/I76u5rLyfXcfwH37NgHPzHF70TnEmc/sQtK');

INSERT INTO `nhom_lien_he` (`id`, `id_nguoi_dung`, `ten_nhom`, `mo_ta`) VALUES
(1, 1, 'Nhóm Đồ Án', 'Thành viên cùng làm bài tập lớn Web'),
(2, 1, 'Lớp K64CNTT', 'Sinh viên cùng lớp chuyên ngành'),
(3, 1, 'Ban Cán Sự', 'Lớp trưởng, bí thư'),
(4, 1, 'Gia đình', 'Người thân trong gia đình');

INSERT INTO `lien_he` (`id`, `id_nguoi_dung`, `id_nhom`, `ho_ten`, `gioi_tinh`, `ngay_sinh`, `so_dien_thoai`, `email`, `don_vi`, `dia_chi`, `ghi_chu`, `yeu_thich`) VALUES
(1, 1, 1, 'Nguyễn Văn An', 'Nam', '2004-03-15', '0900000001', 'an.demo@example.com', 'K64CNTT', 'Sơn La', 'Trưởng nhóm thực hành', 1),
(2, 1, 1, 'Trần Thị Bình', 'Nữ', '2004-11-25', '0900000002', 'binh.demo@example.com', 'K64CNTT', 'Hà Nội', 'Phụ trách kiểm thử', 0),
(3, 1, 2, 'Lê Hoàng Cường', 'Nam', '2004-07-08', '0900000003', NULL, 'K64CNTT', 'Sơn La', 'Bạn cùng lớp', 0),
(4, 1, 3, 'Phạm Thị Dung', 'Nữ', '2004-11-30', '0987654321', 'dung.demo@example.com', 'K64CNTT', 'Sơn La', 'Lớp trưởng', 1),
(5, 1, 4, 'Nguyễn Thị Hoa', 'Nữ', '1975-05-20', '0912345678', NULL, NULL, 'Sơn La', 'Người thân', 1),
(6, 1, 4, 'Nguyễn Văn Nam', 'Nam', '1972-09-02', '0912345679', NULL, NULL, 'Sơn La', 'Người thân', 0);

INSERT INTO `quan_he` (`id_lien_he_a`, `id_lien_he_b`, `loai`, `ghi_chu`) VALUES
(1, 2, 'Bạn học', 'Cùng nhóm bài tập lớn Web'),
(1, 3, 'Bạn học', NULL),
(2, 3, 'Bạn bè', 'Ở cùng ký túc xá'),
(1, 4, 'Bạn học', 'Lớp trưởng'),
(5, 6, 'Gia đình', 'Vợ chồng');
