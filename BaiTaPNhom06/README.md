# Sổ địa chỉ – Danh bạ liên hệ (PHP + MySQL) – Nhóm 02

## Cài đặt (XAMPP)
1. Chép thư mục này vào `C:\xampp\htdocs\sodiachi\`.
2. Bật Apache và MySQL → vào phpMyAdmin → tab **Nhập (Import)** → chọn `so_dia_chi_danh_ba.sql`.
3. Mở http://localhost/sodiachi/ → đăng nhập: `kieuanh@utb.edu.vn` / `123456` (hoặc tự đăng ký).
4. Nếu MySQL có mật khẩu root, sửa trong `db.php`.

## Chức năng
- Đăng ký, đăng nhập, đăng xuất (mật khẩu băm bằng `password_hash`). Mỗi người chỉ thấy danh bạ của mình.
- Liên hệ: thêm, xem chi tiết, sửa, xóa (có màn hình xác nhận, xóa bằng POST).
- Tìm kiếm (tên/SĐT/email/đơn vị), lọc theo nhóm, lọc yêu thích, phân trang, thống kê, sinh nhật trong tháng.
- Nhóm liên hệ: thêm/sửa/xóa (nhóm còn liên hệ thì không xóa được).
- Kết nối giữa các liên hệ (bảng `quan_he`): bạn học, gia đình, đồng nghiệp… hiển thị hai chiều; xem người cùng nhóm.

## Cấu trúc CSDL
`nguoi_dung` 1—n `nhom_lien_he` 1—n `lien_he`; `lien_he` n—n `lien_he` qua `quan_he`.

## Tệp
`index.php` danh sách · `contact_form.php` thêm/sửa · `contact_view.php` chi tiết + kết nối · `contact_delete.php` xác nhận xóa
`groups.php` nhóm · `login/register/logout.php` · `functions.php` hàm chung · `header/footer.php` · `db.php` · `style.css`
