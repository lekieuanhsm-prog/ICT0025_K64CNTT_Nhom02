-- Sổ địa chỉ – Danh bạ liên hệ (bản hoàn chỉnh)
-- Tài khoản mẫu: kieuanh@utb.edu.vn / 123456
CREATE DATABASE IF NOT EXISTS so_dia_chi_danh_ba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE so_dia_chi_danh_ba;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS quan_he, lien_he, nhom_lien_he, nguoi_dung;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE nguoi_dung (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  ho_ten   VARCHAR(100) NOT NULL,
  email    VARCHAR(100) NOT NULL UNIQUE,
  mat_khau VARCHAR(255) NOT NULL,              -- password_hash()
  ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE nhom_lien_he (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  id_nguoi_dung INT NOT NULL,
  ten_nhom      VARCHAR(60) NOT NULL,
  mo_ta         VARCHAR(255) NULL,
  UNIQUE KEY uq_nhom (id_nguoi_dung, ten_nhom),
  CONSTRAINT fk_nhom_nd FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE lien_he (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  id_nguoi_dung INT NOT NULL,
  id_nhom       INT NULL,                      -- NULL = chưa phân nhóm
  ho_ten        VARCHAR(100) NOT NULL,
  gioi_tinh     ENUM('Nam','Nữ','Khác') NOT NULL DEFAULT 'Khác',
  ngay_sinh     DATE NULL,
  so_dien_thoai VARCHAR(15) NOT NULL,
  email         VARCHAR(100) NULL,
  don_vi        VARCHAR(100) NULL,             -- lớp / cơ quan / công ty
  dia_chi       VARCHAR(255) NULL,
  ghi_chu       TEXT NULL,
  yeu_thich     TINYINT(1) NOT NULL DEFAULT 0,
  ngay_tao      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY idx_ten (ho_ten),
  KEY idx_sdt (so_dien_thoai),
  CONSTRAINT fk_lh_nd   FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
  CONSTRAINT fk_lh_nhom FOREIGN KEY (id_nhom) REFERENCES nhom_lien_he(id)     -- còn liên hệ thì không xóa được nhóm
) ENGINE=InnoDB;

-- Quan hệ giữa 2 liên hệ (quan hệ nhiều-nhiều, tự tham chiếu)
-- Luôn lưu a < b để mỗi cặp chỉ có 1 dòng (UNIQUE) và không tự kết nối với chính mình
CREATE TABLE quan_he (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  id_lien_he_a INT NOT NULL,
  id_lien_he_b INT NOT NULL,
  loai         VARCHAR(30) NOT NULL,
  ghi_chu      VARCHAR(150) NULL,
  UNIQUE KEY uq_cap (id_lien_he_a, id_lien_he_b),
  CONSTRAINT ck_a_nho_hon_b CHECK (id_lien_he_a < id_lien_he_b),
  CONSTRAINT fk_qh_a FOREIGN KEY (id_lien_he_a) REFERENCES lien_he(id) ON DELETE CASCADE,
  CONSTRAINT fk_qh_b FOREIGN KEY (id_lien_he_b) REFERENCES lien_he(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===== DỮ LIỆU MẪU =====
INSERT INTO nguoi_dung (id, ho_ten, email, mat_khau) VALUES
(1, 'Lê Thị Kiều Anh', 'kieuanh@utb.edu.vn', '$2y$12$Ou48QGg7WbNRZtn.5/I76u5rLyfXcfwH37NgHPzHF70TnEmc/sQtK');

INSERT INTO nhom_lien_he (id, id_nguoi_dung, ten_nhom, mo_ta) VALUES
(1, 1, 'Nhóm 02',     'Thành viên cùng làm bài tập lớn Web'),
(2, 1, 'Lớp K64CNTT', 'Sinh viên cùng lớp chuyên ngành'),
(3, 1, 'Ban Cán Sự',  'Lớp trưởng, bí thư'),
(4, 1, 'Gia đình',    'Người thân');

INSERT INTO lien_he (id, id_nguoi_dung, id_nhom, ho_ten, gioi_tinh, ngay_sinh, so_dien_thoai, email, don_vi, dia_chi, yeu_thich) VALUES
(1, 1, 1, 'Phin Sạ Vẳn',     'Nam', '2004-03-15', '0900000002', 'phin@example.com', 'K64CNTT', 'Sơn La', 1),
(2, 1, 1, 'Bùi Quang Huy',   'Nam', '2004-11-25', '0900000003', 'huy@example.com',  'K64CNTT', 'Hà Nội', 0),
(3, 1, 2, 'Seng Su Li',      'Nam', '2004-07-08', '0900000004', NULL,               'K64CNTT', 'Sơn La', 0),
(4, 1, 3, 'Lò Thị Mai',      'Nữ',  '2004-11-30', '0987654321', 'mai@example.com',  'K64CNTT', 'Sơn La', 1),
(5, 1, 4, 'Nguyễn Thị Hoa',  'Nữ',  '1975-05-20', '0912345678', NULL,               NULL,      'Sơn La', 1),
(6, 1, 4, 'Lê Văn Nam',      'Nam', '1972-09-02', '0912345679', NULL,               NULL,      'Sơn La', 0),
(7, 1, 2, 'Trần Minh Đức',   'Nam', '2004-01-12', '0901112223', 'duc@example.com',  'K64CNTT', 'Hà Nội', 0);

INSERT INTO quan_he (id_lien_he_a, id_lien_he_b, loai, ghi_chu) VALUES
(1, 2, 'Bạn học',  'Cùng nhóm bài tập lớn Web'),
(1, 3, 'Bạn học',  NULL),
(2, 3, 'Bạn bè',   'Ở cùng ký túc xá'),
(2, 7, 'Bạn học',  NULL),
(1, 4, 'Bạn học',  'Lớp trưởng'),
(5, 6, 'Gia đình', 'Vợ chồng');
