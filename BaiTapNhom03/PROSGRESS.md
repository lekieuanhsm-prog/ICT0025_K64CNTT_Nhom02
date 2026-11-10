## Phân công thành viên:
  + Cặp 1: Lê Thị Kiều Anh & Phin Sạ Vẳn: Mở rộng form `dang_ky.php`, `dang_nhap.php` thêm mã SV, năm sinh, lớp và kiểm tra rỗng.
  + Cặp 2: Bùi Quang Huy & Seng su Li : Xây dựng trang `project_tich_hop.php` quản lý mảng, chạy kiểm thử.

## 1. Kết quả thảo luận (Mục 2.11 – 2.13)
- **Hàm và mảng:** Hàm nhận tham số mã trạng thái và trả về chuỗi nhãn. Mảng kết hợp nhiều chiều giúp lưu các trường hồ sơ sinh viên (`ma_sv`, `ho_ten`, `lop`, `nam_sinh`, `sdt`).

## 2. Các điểm mới bổ sung so với mẫu gốc
1. Thêm các trường sinh viên: Mã sinh viên (`ma_sv`), Lớp (`lop`), Năm sinh (`nam_sinh`) tự tính số tuổi.
2. Kiểm tra dữ liệu (Validation): Dùng `trim()` chống dấu cách rỗng, kiểm tra năm sinh hợp lệ và kiểm tra định dạng email bằng `filter_var()`.
3. Chống XSS: Bọc toàn bộ dữ liệu in ra màn hình bằng `htmlspecialchars()`.

## 3. Bảng kiểm thử các chức năng

+ Đăng ký (để trống Họ tên hoặc Mã SV): Hiện thông báo đỏ nhắc nhập đúng ô bị thiếu → Đạt.  
+ Đăng ký (năm sinh nhập chữ hoặc bỏ trống): Báo lỗi yêu cầu nhập năm sinh hợp lệ → Đạt.  
+ Đăng ký (mật khẩu nhập lại không khớp): Báo lỗi hai mật khẩu không trùng khớp → Đạt.  
+ Đăng ký (nhập đủ và đúng thông tin): Hiện bảng tóm tắt hồ sơ và tính đúng số tuổi → Đạt.  
+ Đăng nhập (nhập đúng tài khoản và mật khẩu $\ge$ 6 ký tự): Đăng nhập thành công và dẫn sang trang danh bạ → Đạt.  
+ Tìm kiếm GET (gõ từ khóa "Anh" hoặc "K64"): Danh sách lọc đúng các sinh viên có thông tin tương ứng → Đạt.  
+ Thêm mới POST (nhập đủ thông tin liên hệ mới): Bản ghi mới được thêm ngay vào cuối danh sách bảng → Đạt.   