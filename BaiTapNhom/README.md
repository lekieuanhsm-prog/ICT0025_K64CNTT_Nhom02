# THIẾT KẾ HỆ THỐNG – BÀI TẬP LỚN LẬP TRÌNH ỨNG DỤNG WEB

## 1. Thông tin chung
- **Nhóm thực hiện:** Nhóm 02 – Lớp K64CNTT (Trường Đại học Tây Bắc)
- **Học phần:** Lập trình ứng dụng Web (ICT0025)
- **Đề tài:** Hệ thống Sổ địa chỉ – Danh bạ liên hệ trực tuyến
- **Tên Cơ sở dữ liệu:** `so_dia_chi_danh_ba` (MySQL, `utf8mb4_unicode_ci`, `InnoDB`)

## 2. Danh sách thành viên nhóm
1. **Lê Thị Kiều Anh** (MSSV: `2023A0832`) – Nhóm trưởng
2. **Bùi Quang Huy** (MSSV: `2023A0880`)
3. **Phin Sạ Vẳn** (MSSV: `2023AN068`)
4. **Seng su Li** (MSSV: `2023AN072`)

## 3. Hướng dẫn tạo CSDL và Import tệp `database.sql`
1. Mở **XAMPP Control Panel**, khởi động **Apache** và **MySQL**.
2. Truy cập `http://localhost/phpmyadmin`.
3. Bấm **Mới (New)** ở cột bên trái, nhập tên cơ sở dữ liệu là **`so_dia_chi_danh_ba`**, chọn bảng mã **`utf8mb4_unicode_ci`** và bấm **Tạo**.
4. Chọn CSDL `so_dia_chi_danh_ba` vừa tạo $\rightarrow$ chuyển sang thẻ **Nhập (Import)** $\rightarrow$ chọn tệp `database.sql` trong thư mục `ThietKe` $\rightarrow$ bấm **Nhập (Import)**.
5. Kiểm tra đủ 4 bảng (`nguoi_dung`, `nhom_lien_he`, `lien_he`, `quan_he`) cùng dữ liệu giả lập mẫu.

## 4. Phần chưa hoàn thành hoặc cần xin ý kiến góp ý giảng viên
- **Phần đã hoàn thiện:** Thiết kế đồng bộ 4 bảng CSDL (`nguoi_dung`, `nhom_lien_he`, `lien_he`, `quan_he`), 6 loại sơ đồ UML, tệp `database.sql` chạy chuẩn trên CSDL trống và khớp hoàn toàn với bộ mã nguồn PHP của nhóm.
- **Điểm cần xin ý kiến góp ý:**
  1. Trong bảng `quan_he` (liên kết giữa hai liên hệ), nhóm dùng cơ chế lưu cặp `(min(id_a, id_b), max(id_a, id_b))` kèm ràng buộc `CHECK (id_lien_he_a < id_lien_he_b)` để biểu diễn quan hệ hai chiều không trùng lặp. Nhóm xin ý kiến thầy xem với các quan hệ phân vai một chiều (ví dụ: *Cô ruột – Cháu*) thì nên giữ một nhãn chung như hiện tại hay tách thêm cột vai trò đối ứng ạ.
  2. Chức năng nhắc sinh nhật trong tháng hiện tại (`MONTH(ngay_sinh) = MONTH(CURDATE())`) được hiển thị trực tiếp trên trang chủ; nhóm dự kiến giữ nguyên phạm vi này cho bài tập lớn.
