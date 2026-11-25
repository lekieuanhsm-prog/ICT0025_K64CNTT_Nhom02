# BẢNG PHÂN CÔNG NHIỆM VỤ THIẾT KẾ & BÀI CÁ NHÂN (NHÓM 02)

- **Đề tài:** Hệ thống Sổ địa chỉ – Danh bạ liên hệ trực tuyến
- **Cơ sở dữ liệu chung:** `so_dia_chi_danh_ba`

| Thành viên | Việc thiết kế nhóm được giao | Phần dữ liệu làm bài cá nhân (CRUD) | Sản phẩm cần hoàn thành & Người phối hợp |
| :--- | :--- | :--- | :--- |
| **Lê Thị Kiều Anh**<br> | - Tổng hợp đặc tả hệ thống và mô tả chi tiết 2 chức năng (`contact_form.php`, `contact_delete.php`).<br>- Thiết kế sơ đồ ERD 4 bảng và biên soạn tài liệu `ThietKe.pdf`. | Quản lý **Hồ sơ liên hệ** (`lien_he`: thêm, xem, sửa, xóa, đánh dấu yêu thích). | - Sơ đồ ERD, tài liệu `ThietKe.pdf` và ứng dụng CRUD `lien_he`.<br>- Phối hợp với **Bùi Quang Huy** để đồng bộ khóa ngoại `id_nhom`. |
| **Bùi Quang Huy**<br> | - Viết kịch bản `database.sql` (MySQL, `utf8mb4`, `InnoDB`) và tạo dữ liệu giả.<br>- Vẽ sơ đồ lớp (`Class Diagram`) và sơ đồ triển khai (`Deployment Diagram`). | Quản lý **Nhóm liên hệ** (`nhom_lien_he`: thêm, xem, sửa, xóa nhóm và kiểm tra ràng buộc còn liên hệ). | - Tệp `database.sql`, sơ đồ Lớp, sơ đồ Triển khai và bài CRUD `nhom_lien_he`.<br>- Phối hợp với **Lê Thị Kiều Anh**. |
| **Phin Sạ Vẳn**<br> | - Vẽ sơ đồ ca sử dụng (`Use Case Diagram`) và sơ đồ hoạt động (`Activity Diagram`).<br>- Tạo tệp nguồn sơ đồ chỉnh sửa (`.drawio` / `.svg`). | Quản lý **Kết nối mối quan hệ** (`quan_he`: thiết lập và hủy kết nối hai chiều giữa hai liên hệ). | - Sơ đồ Use Case, sơ đồ Hoạt động, tệp nguồn sơ đồ và bài CRUD `quan_he`.<br>- Phối hợp với **Seng su Li**. |
| **Seng su Li**<br> | - Vẽ sơ đồ tuần tự (`Sequence Diagram`) và sơ đồ trạng thái (`State Diagram`).<br>- Kiểm thử import `database.sql` trên CSDL trống và tổng hợp `README.md`. | Quản lý **Tài khoản & Thông tin người dùng** (`nguoi_dung`: đăng ký, đăng nhập, cập nhật thông tin). | - Sơ đồ Tuần tự, sơ đồ Trạng thái, tệp `README.md` và bài CRUD `nguoi_dung`.<br>- Phối hợp với **Phin Sạ Vẳn**. |
