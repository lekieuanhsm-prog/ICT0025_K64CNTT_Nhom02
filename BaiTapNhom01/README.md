# BÁO CÁO THỰC HÀNH NHÓM 02

**Tên nhóm:** Nhom02  
**Đề tài:** Sổ địa chỉ – Danh bạ liên hệ trực tuyến  
**Ngôn ngữ lập trình:** PHP, HTML, CSS  
**Công cụ sử dụng:** Visual Studio Code, XAMPP

## 1. Hướng dẫn chạy chương trình

- Mở XAMPP Control Panel và khởi động Apache.
- Tạo thư mục `Nhom02` trong `C:\xampp\htdocs`.
- Lưu 6 file PHP vào thư mục trên.
- Mở trình duyệt và truy cập:

`http://localhost/Nhom02/ten-tep.php`

Thay tên file tương ứng để chạy các bài còn lại.

Chương trình chưa sử dụng cơ sở dữ liệu MySQL.

## 2. Nội dung và kết quả thực hành

### Bài 01: 01_cu_phap.php – Cú pháp PHP

**Nội dung:**
- Kết hợp HTML với PHP.
- Sử dụng `echo` hiển thị lời chào và ngày hiện tại.
- Tạo biểu mẫu nhập tên người dùng.

**Kết quả:** Khi nhập tên và nhấn Gửi, chương trình hiển thị lời chào theo tên vừa nhập.

**Giải thích:** PHP thực thi trên máy chủ, trình duyệt chỉ nhận kết quả HTML sau khi PHP xử lý.

### Bài 02: 02_bien.php – Biến trong PHP

**Nội dung:**
- Khai báo biến lưu tên, nhóm, số điện thoại và số cuộc gọi.
- Hiển thị thông tin hai liên hệ.
- Tính tổng số cuộc gọi.
- Cho phép cập nhật thông tin qua biểu mẫu.

**Kết quả:** Ban đầu có 2 liên hệ với tổng số cuộc gọi là 1. Khi cập nhật dữ liệu, chương trình hiển thị thông tin mới và tính lại tổng số cuộc gọi.

**Giải thích:** Biến trong PHP bắt đầu bằng `$`, không cần khai báo kiểu dữ liệu và có thể thay đổi giá trị.

### Bài 03: 03_hang.php – Hằng số PHP

**Nội dung:**
- Sử dụng `define()` và `const` khai báo hằng số.
- Xây dựng chức năng tính phí lưu trữ danh bạ.
- Cho phép chọn số tháng đăng ký.

**Kết quả:**
- Phí cố định: 10.000 VNĐ/tháng.
- Giới hạn: 500 liên hệ.
- Đăng ký 3 tháng: 30.000 VNĐ.
- Đăng ký 6 tháng: 60.000 VNĐ.

**Giải thích:** Hằng số có giá trị cố định trong quá trình thực thi, còn biến có thể thay đổi.

### Bài 04: 04_kieu_du_lieu.php – Kiểu dữ liệu

**Nội dung:**
- Sử dụng các kiểu `string`, `int`, `float`, `bool`, `null`.
- Sử dụng `var_dump()` kiểm tra kiểu dữ liệu.
- Thực hiện ép kiểu dữ liệu.
- Tạo biểu mẫu cập nhật thông tin liên hệ.

**Kết quả mặc định:**
- Họ tên: Nguyễn Văn An – `string`.
- Năm sinh: 2004 – `int`.
- Đánh giá: 4.8 – `float`.
- Bạn thân: `bool(true)`.
- Ghi chú: `NULL`.

**Giải thích:** `var_dump()` giúp kiểm tra kiểu và giá trị của biến. Dữ liệu từ biểu mẫu được ép sang kiểu phù hợp.

### Bài 05: 05_toan_tu.php – Toán tử PHP

**Nội dung:**
- Thực hiện các phép cộng, trừ, nhân, chia, chia dư.
- Sử dụng toán tử gán kết hợp `+=`.
- So sánh `==` và `===`.
- Sử dụng toán tử logic `&&`.

**Kết quả với a = 15, b = 4:**
- Cộng: 19.
- Trừ: 11.
- Nhân: 60.
- Chia: 3.75.
- Chia dư: 3.
- Gán kết hợp `+= 5`: 20.
- `5 == "5"`: `true`.
- `5 === "5"`: `false`.
- Liên hệ thường xuyên: Đạt điều kiện.

**Giải thích:** `==` so sánh giá trị sau khi ép kiểu nếu cần, còn `===` so sánh cả giá trị và kiểu dữ liệu.

### Bài 06: 06_van_dung.php – Vận dụng tính hóa đơn

**Nội dung:**
- Xây dựng chức năng tính tiền mua thẻ danh bạ NFC.
- Nhập tên mặt hàng, số lượng và đơn giá.
- Áp dụng phí dịch vụ 5%.
- Tính tổng tiền thanh toán.

**Công thức:**
- Tiền hàng = Số lượng × Đơn giá.
- Tiền phí = Tiền hàng × 5%.
- Tổng thanh toán = Tiền hàng + Tiền phí.

**Kết quả thử nghiệm:**

Trường hợp 1:
- Số lượng: 3.
- Đơn giá: 25.000 VNĐ.
- Tiền hàng: 75.000 VNĐ.
- Phí: 3.750 VNĐ.
- Tổng: 78.750 VNĐ.

Trường hợp 2:
- Số lượng: 10.
- Đơn giá: 80.000 VNĐ.
- Tiền hàng: 800.000 VNĐ.
- Phí: 40.000 VNĐ.
- Tổng: 840.000 VNĐ.

**Giải thích:** Chương trình vận dụng biến, hằng số và toán tử để tính hóa đơn. Người dùng có thể thay đổi dữ liệu và tính lại kết quả.

## 3. Khó khăn và cách xử lý

**Khó khăn:**
- Chưa quen kết hợp PHP với HTML.
- Dễ nhầm lẫn giữa biến và hằng số.
- Khó xác định kiểu dữ liệu khi nhập từ biểu mẫu.
- Có thể gặp lỗi cú pháp hoặc hiển thị tiếng Việt.

**Cách xử lý:**
- Kiểm tra cú pháp và dấu kết thúc lệnh.
- Sử dụng `var_dump()` kiểm tra kiểu dữ liệu.
- Sử dụng `isset()` để kiểm tra dữ liệu nhập.
- Sử dụng `<meta charset="UTF-8">` để hiển thị tiếng Việt.
- Chạy thử từng bài trên trình duyệt.

## 4. Kết quả thực hiện của nhóm

Nhóm đã xây dựng 6 file PHP theo yêu cầu bài thực hành.

Ngoài kiến thức PHP cơ bản, nhóm còn bổ sung các biểu mẫu nhập liệu, cập nhật thông tin và tính toán kết quả nhằm tăng tính tương tác cho chương trình.
