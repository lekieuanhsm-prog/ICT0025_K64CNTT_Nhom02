# TÌM HIỂU VỀ API

## 1. Khái niệm API

API (Application Programming Interface) là giao diện lập trình ứng dụng, cho phép các phần mềm hoặc hệ thống khác nhau giao tiếp và trao đổi dữ liệu với nhau.

API đóng vai trò trung gian giúp ứng dụng gửi yêu cầu và nhận kết quả từ một hệ thống khác mà không cần biết toàn bộ cách hệ thống đó được xây dựng.

## 2. Cách thức hoạt động của API

API thường hoạt động theo quy trình sau:

1. Người dùng thực hiện một thao tác trên ứng dụng.
2. Ứng dụng gửi yêu cầu (Request) đến API.
3. API tiếp nhận và xử lý yêu cầu.
4. Hệ thống trả về kết quả (Response).
5. Ứng dụng nhận và hiển thị dữ liệu cho người dùng.

## 3. Các phương thức HTTP thường dùng

- GET: Lấy dữ liệu từ máy chủ.
- POST: Gửi dữ liệu mới lên máy chủ.
- PUT: Cập nhật toàn bộ dữ liệu hoặc tài nguyên.
- PATCH: Cập nhật một phần dữ liệu.
- DELETE: Xóa dữ liệu.

## 4. Các thành phần cơ bản của API

- Endpoint: Địa chỉ mà ứng dụng gửi yêu cầu đến.
- Request: Yêu cầu được gửi từ ứng dụng.
- Response: Kết quả trả về từ máy chủ.
- Header: Chứa thông tin bổ sung của yêu cầu hoặc phản hồi.
- Body: Chứa dữ liệu được gửi đi hoặc trả về.

## 5. Vai trò của API

- Giúp các ứng dụng có thể kết nối và trao đổi dữ liệu.
- Hỗ trợ xây dựng hệ thống phần mềm linh hoạt.
- Tiết kiệm thời gian phát triển ứng dụng.
- Cho phép tích hợp các dịch vụ bên ngoài.
- Giúp phân chia chức năng giữa giao diện và máy chủ.

## 6. Ví dụ ứng dụng API

Trong hệ thống quản lý danh bạ:
- GET /contacts: Lấy danh sách liên hệ.
- POST /contacts: Thêm liên hệ mới.
- PUT /contacts/1: Cập nhật liên hệ có ID là 1.
- DELETE /contacts/1: Xóa liên hệ có ID là 1.

## 7. Kết luận

API là thành phần quan trọng trong phát triển phần mềm hiện đại. API giúp các hệ thống giao tiếp, chia sẻ dữ liệu và kết nối với nhau một cách thuận tiện.