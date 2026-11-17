-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2026 lúc 08:33 AM
-- Phiên bản máy phục vụ: 10.11.16-MariaDB
-- Phiên bản PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `so_dia_chi_danh_ba`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lien_he`
--

CREATE TABLE `lien_he` (
  `id` int(11) NOT NULL,
  `ma_sv` varchar(20) DEFAULT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `don_vi_lop` varchar(80) DEFAULT NULL,
  `so_dien_thoai` varchar(15) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1,
  `id_nhom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lien_he`
--

INSERT INTO `lien_he` (`id`, `ma_sv`, `ho_ten`, `don_vi_lop`, `so_dien_thoai`, `trang_thai`, `id_nhom`) VALUES
(1, '231031002', 'Phin Sạ Vẳn', 'K64CNTT', '0900000002', 1, 1),
(2, '231031003', 'Bùi Quang Huy', 'K64CNTT', '0900000003', 1, 1),
(3, '231031004', 'Seng su Li', 'K64CNTT', '0900000004', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ma_sv` varchar(20) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mat_khau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ma_sv`, `ho_ten`, `email`, `mat_khau`) VALUES
(1, '231031001', 'Lê Thị Kiều Anh', 'kieuanh@utb.edu.vn', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhom_lien_he`
--

CREATE TABLE `nhom_lien_he` (
  `id` int(11) NOT NULL,
  `ten_nhom` varchar(60) NOT NULL,
  `mo_ta` varchar(255) DEFAULT NULL,
  `id_nguoi_dung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhom_lien_he`
--

INSERT INTO `nhom_lien_he` (`id`, `ten_nhom`, `mo_ta`, `id_nguoi_dung`) VALUES
(1, 'Nhóm 02', 'Thành viên cùng làm bài tập lớn Web', 1),
(2, 'Lớp K64CNTT', 'Sinh viên cùng lớp chuyên ngành', 1),
(3, 'Ban Cán Sự', 'Liên hệ lớp trưởng, bí thư', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `lien_he`
--
ALTER TABLE `lien_he`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lh_nhom` (`id_nhom`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_sv` (`ma_sv`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `nhom_lien_he`
--
ALTER TABLE `nhom_lien_he`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nhom_nd` (`id_nguoi_dung`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `lien_he`
--
ALTER TABLE `lien_he`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `nhom_lien_he`
--
ALTER TABLE `nhom_lien_he`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `lien_he`
--
ALTER TABLE `lien_he`
  ADD CONSTRAINT `fk_lh_nhom` FOREIGN KEY (`id_nhom`) REFERENCES `nhom_lien_he` (`id`);

--
-- Ràng buộc cho bảng `nhom_lien_he`
--
ALTER TABLE `nhom_lien_he`
  ADD CONSTRAINT `fk_nhom_nd` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
