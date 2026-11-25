# BÁO CÁO ĐÓNG GÓP THỰC TẾ, KIỂM TRA CHÉO & SỬ DỤNG AI (NHÓM 02)

## 1. Ghi nhận đóng góp thực tế và kết quả kiểm tra chéo

1. **Lê Thị Kiều Anh **
   - **Phần thực tế đã làm:** Hoàn thiện phần mô tả hệ thống, đặc tả 2 chức năng thêm/xóa liên hệ, thiết kế sơ đồ ERD 4 bảng (`nguoi_dung`, `nhom_lien_he`, `lien_he`, `quan_he`), viết bảng mô tả trường dữ liệu và tổng hợp xuất tệp `ThietKe.pdf`. Giải thích được mối liên hệ giữa chức năng thêm/sửa/xóa liên hệ với các bảng `lien_he`, `nhom_lien_he` và `quan_he`.
   - **Phần của bạn khác đã kiểm tra:** Kiểm tra tệp `database.sql` do **Bùi Quang Huy** viết bằng cách import trực tiếp vào CSDL trống `so_dia_chi_danh_ba` trên phpMyAdmin và đối chiếu từng cột với mã nguồn PHP của nhóm.
   - **Kết quả kiểm tra:** Tệp SQL import thành công 100%, không báo lỗi cú pháp, các khóa ngoại và ràng buộc `ON DELETE RESTRICT` / `CHECK (id_lien_he_a < id_lien_he_b)` hoạt động khớp hoàn toàn với mã nguồn.

2. **Bùi Quang Huy **
   - **Phần thực tế đã làm:** Viết hoàn chỉnh tệp `database.sql` chuẩn InnoDB/utf8mb4 kèm dữ liệu giả lập không chứa thông tin thật; vẽ sơ đồ Lớp (`Class Diagram`) và sơ đồ Triển khai (`Deployment Diagram`). Giải thích được cách ánh xạ các lớp `NguoiDung`, `NhomLienHe`, `LienHe`, `QuanHe` sang các bảng trong MySQL.
   - **Phần của bạn khác đã kiểm tra:** Kiểm tra sơ đồ Use Case và sơ đồ Hoạt động của **Phin Sạ Vẳn** đối chiếu với mô tả chức năng trong `ThietKe.pdf`.
   - **Kết quả kiểm tra:** Các ca sử dụng khớp với chức năng hệ thống; sơ đồ hoạt động có đủ nhánh rẽ khi dữ liệu rỗng/sai hoặc trùng số điện thoại.

3. **Phin Sạ Vẳn **
   - **Phần thực tế đã làm:** Vẽ sơ đồ Ca sử dụng (`Use Case`), sơ đồ Hoạt động (`Activity`) cho chức năng thêm/sửa liên hệ và xuất gói tệp nguồn sơ đồ (`.drawio` và `.svg`) trong thư mục `so_do_nguon`. Giải thích được luồng kiểm tra CSRF và dữ liệu đầu vào trước khi ghi vào bảng `lien_he`.
   - **Phần của bạn khác đã kiểm tra:** Kiểm tra sơ đồ Tuần tự và sơ đồ Trạng thái của **Seng su Li**.
   - **Kết quả kiểm tra:** Thứ tự gọi hàm trong sơ đồ Tuần tự khớp với luồng xử lý PHP–PDO–MySQL; sơ đồ Trạng thái thể hiện rõ vòng đời bản ghi liên hệ (Thường $\leftrightarrow$ Yêu thích $\rightarrow$ Xóa).

4. **Seng su Li **
   - **Phần thực tế đã làm:** Vẽ sơ đồ Tuần tự (`Sequence`) cho luồng thêm liên hệ, sơ đồ Trạng thái (`State`) cho đối tượng liên hệ, viết hướng dẫn cài đặt trong `README.md` và rà soát toàn bộ gói nộp `Nhom02_ThietKe.zip`.
   - **Phần của bạn khác đã kiểm tra:** Kiểm tra bảng mô tả CSDL và sơ đồ ERD của **Lê Thị Kiều Anh** đối chiếu với tệp `database.sql`.
   - **Kết quả kiểm tra:** Tên bảng, tên cột, kiểu dữ liệu và khóa ngoại giữa sơ đồ ERD, bảng mô tả trong `ThietKe.pdf` và `database.sql` thống nhất hoàn toàn.

---

## 2. Báo cáo việc sử dụng công cụ AI của từng thành viên

- **Lê Thị Kiều Anh:**
  - *Công cụ sử dụng:* Gemini.
  - *Câu hỏi chính:* Cách chuẩn hóa quan hệ nhiều – nhiều tự tham chiếu cho bảng `quan_he` giữa hai liên hệ và cách trình bày đặc tả chức năng kèm trường hợp không hợp lệ.
  - *Phần đã dùng / giữ nguyên:* Tham khảo cấu trúc bảng đặc tả chức năng và gợi ý dùng cặp khóa `(id_lien_he_a, id_lien_he_b)` với `UNIQUE`.
  - *Phần tự sửa & kiểm tra:* Tự điều chỉnh danh sách thuộc tính của bảng `lien_he` (`yeu_thich`, `ngay_sinh`, `don_vi`) cho khớp với mã nguồn thực tế và đối chiếu lại toàn bộ ràng buộc khóa ngoại với tệp SQL.

- **Bùi Quang Huy:**
  - *Công cụ sử dụng:* Gemini.
  - *Câu hỏi chính:* Cách viết ràng buộc `ON DELETE RESTRICT` và `CHECK (id_lien_he_a < id_lien_he_b)` trong MySQL InnoDB để chặn xóa nhóm khi còn liên hệ và tránh tự kết nối trùng lặp.
  - *Phần đã dùng / giữ nguyên:* Cú pháp khai báo `CONSTRAINT ... FOREIGN KEY` và `CHECK` chuẩn InnoDB.
  - *Phần tự sửa & kiểm tra:* Tự viết bộ dữ liệu giả lập (`INSERT INTO`), loại bỏ lệnh `DROP DATABASE` theo quy định nộp bài thiết kế và chạy thử import trên phpMyAdmin.

- **Phin Sạ Vẳn:**
  - *Công cụ sử dụng:* Gemini.
  - *Câu hỏi chính:* Cách thể hiện quan hệ `<<include>>` trong sơ đồ Use Case và nhánh lặp lại khi nhập sai dữ liệu trong sơ đồ Activity.
  - *Phần đã dùng / giữ nguyên:* Bố cục các bước kiểm tra dữ liệu đầu vào trong sơ đồ Activity.
  - *Phần tự sửa & kiểm tra:* Tự chỉnh sửa lại tên các ca sử dụng và xuất tệp nguồn `.drawio` để giảng viên có thể mở chỉnh sửa trực tiếp.

- **Seng su Li:**
  - *Công cụ sử dụng:* Không sử dụng AI (tự tham khảo giáo trình học phần và đối chiếu mã nguồn nhóm để vẽ sơ đồ Tuần tự, sơ đồ Trạng thái và viết `README.md`).
