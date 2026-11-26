# TÌM HIỂU VỀ MVC

## 1. Khái niệm MVC

MVC (Model - View - Controller) là mô hình kiến trúc phần mềm dùng để tổ chức và quản lý mã nguồn của ứng dụng.

MVC chia ứng dụng thành ba thành phần chính là Model, View và Controller. Mỗi thành phần đảm nhận một nhiệm vụ riêng, giúp chương trình dễ phát triển, bảo trì và nâng cấp.

## 2. Các thành phần của MVC

### 2.1. Model (Mô hình)
- Quản lý dữ liệu của ứng dụng.
- Thực hiện các thao tác truy xuất và xử lý dữ liệu.
- Làm việc với cơ sở dữ liệu.
- Ví dụ: Lấy danh sách liên hệ từ cơ sở dữ liệu.

### 2.2. View (Giao diện)
- Là phần giao diện hiển thị cho người dùng.
- Hiển thị dữ liệu và tiếp nhận thao tác từ người dùng.
- Ví dụ: Trang hiển thị danh sách liên hệ, biểu mẫu thêm liên hệ.

### 2.3. Controller (Bộ điều khiển)
- Tiếp nhận yêu cầu từ người dùng.
- Xử lý yêu cầu và điều phối hoạt động giữa Model và View.
- Ví dụ: Tiếp nhận yêu cầu thêm liên hệ và gọi Model để lưu dữ liệu.

## 3. Cách thức hoạt động của MVC

Quy trình hoạt động cơ bản:

1. Người dùng thực hiện thao tác trên giao diện View.
2. Controller tiếp nhận yêu cầu.
3. Controller gọi Model để xử lý dữ liệu nếu cần.
4. Model thực hiện xử lý và trả kết quả cho Controller.
5. Controller chuyển dữ liệu đến View.
6. View hiển thị kết quả cho người dùng.

## 4. Ưu điểm của mô hình MVC

- Phân chia rõ ràng các thành phần trong chương trình.
- Giúp mã nguồn dễ quản lý và bảo trì.
- Hỗ trợ nhiều người cùng phát triển dự án.
- Dễ dàng nâng cấp và mở rộng hệ thống.
- Có thể tái sử dụng các thành phần trong ứng dụng.

## 5. Nhược điểm của mô hình MVC

- Cấu trúc ban đầu có thể phức tạp đối với người mới học.
- Cần tổ chức mã nguồn hợp lý để tránh rối.
- Với ứng dụng nhỏ, việc chia thành nhiều thành phần có thể làm tăng số lượng file và công việc quản lý.

## 6. Ví dụ ứng dụng MVC

Trong hệ thống quản lý danh bạ liên hệ:

- Model: Quản lý thông tin liên hệ như họ tên, số điện thoại, địa chỉ.
- View: Hiển thị danh sách liên hệ và biểu mẫu thêm, sửa.
- Controller: Xử lý các yêu cầu thêm, sửa, xóa và xem thông tin liên hệ.

## 7. Kết luận

MVC là mô hình kiến trúc phổ biến trong phát triển phần mềm. Việc phân chia chương trình thành Model, View và Controller giúp mã nguồn rõ ràng, dễ quản lý, bảo trì và phát triển.