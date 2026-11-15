-- Cơ sở dữ liệu: Quản lý danh bạ liên hệ (Nhóm 02 - K64CNTT)
CREATE DATABASE IF NOT EXISTS ql_danhba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ql_danhba;

DROP TABLE IF EXISTS lien_he;
DROP TABLE IF EXISTS nhom_lien_he;
DROP TABLE IF EXISTS nguoi_dung;

-- 1. Bảng người dùng (tài khoản đăng nhập)
CREATE TABLE nguoi_dung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_sv VARCHAR(20) NOT NULL UNIQUE,
    ho_ten VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL
);

-- 2. Bảng nhóm danh bạ
CREATE TABLE nhom_lien_he (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_nhom VARCHAR(50) NOT NULL,
    mo_ta VARCHAR(200),
    id_nguoi_dung INT NOT NULL,
    FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id)
);

-- 3. Bảng chi tiết liên hệ
CREATE TABLE lien_he (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_sv VARCHAR(20),
    ho_ten VARCHAR(100) NOT NULL,
    lop VARCHAR(50),
    nam_sinh INT,
    so_dien_thoai VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    trang_thai TINYINT DEFAULT 1,
    id_nhom INT NOT NULL,
    FOREIGN KEY (id_nhom) REFERENCES nhom_lien_he(id)
);

-- Dữ liệu mẫu kiểm thử
INSERT INTO nguoi_dung (ma_sv, ho_ten, email, mat_khau) VALUES
('231031001', 'Lê Thị Kiều Anh', 'kieuanh.test@utb.edu.vn', '123456'),
('231031002', 'Phin Sạ Vẳn', 'phinsavan.test@utb.edu.vn', '123456');

INSERT INTO nhom_lien_he (ten_nhom, mo_ta, id_nguoi_dung) VALUES
('Lớp K64CNTT', 'Danh sách các bạn cùng lớp', 1),
('Nhóm đồ án Web', 'Thành viên nhóm 02 môn ICT0025', 1);

INSERT INTO lien_he (ma_sv, ho_ten, lop, nam_sinh, so_dien_thoai, email, trang_thai, id_nhom) VALUES
('231031001', 'Lê Thị Kiều Anh', 'K64CNTT', 2005, '0900000001', 'kieuanh.test@utb.edu.vn', 1, 2),
('231031002', 'Phin Sạ Vẳn', 'K64CNTT', 2004, '0900000002', 'phinsavan.test@utb.edu.vn', 1, 2),
('231031003', 'Bùi Quang Huy', 'K64CNTT', 2005, '0900000003', 'quanghuy.test@utb.edu.vn', 1, 2),
('231031004', 'Seng su Li', 'K64CNTT', 2004, '0900000004', 'sengsuli.test@utb.edu.vn', 1, 2);
