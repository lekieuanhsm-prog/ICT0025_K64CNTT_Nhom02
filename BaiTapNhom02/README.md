# 05/11/2026
- Học phần: Lập trình ứng dụng Web (ICT0025)
- Nhóm: Nhóm 02 (K64CNTT) - Đề tài: Sổ địa chỉ – Danh bạ liên hệ trực tuyến
- Thành viên:
  + Cặp 1: Lê Thị Kiều Anh và Phin Sạ Vẳn  (Nhiệm vụ 2 if & Nhiệm vụ 3 for)
  + Cặp 2: Bùi Quang Huy và Seng su Li (Nhiệm vụ 2 switch & Nhiệm vụ 3 while)

## 1. Kết quả thảo luận Nhiệm vụ 1 (Ví dụ A - D)
- **Ví dụ A (if/else):**
  + Điểm 5 -> `Cần cố gắng`
  + Điểm 6.5 -> `Khá`
  + Điểm 8 -> `Giỏi`
- **Ví dụ B (switch):**
  + Trạng thái 1 -> `Mới tạo`; Trạng thái 2 -> `Đang xử lý`; Trạng thái 9 -> `Không xác định` (nhờ default).
  + Xóa break ở case 2: Bị in liền `Đang xử lýKhông xác định` do trôi xuống dưới.
- **Ví dụ C (for):** In `1 2 3 4 5 `, lặp 5 lần, giá trị cuối của $i là 6. Khi đổi thành `< 5` thì chỉ in `1 2 3 4 ` (lặp 4 lần, $i cuối là 5).
- **Ví dụ D (while):** In `10 7 4 1 `, lặp 4 lần, giá trị cuối của $n là -2. Đổi thành `+ 3` bị lặp vô tận vì $n$ luôn lớn hơn 0.

## 2. Kết quả Nhiệm vụ 2 & 3
- **Nhiệm vụ 2 ( Trạng thái):**
  + Thử 1 -> Cả 2 cách đều in `Mới tạo`
  + Thử 2 -> Cả 2 cách đều in `Đang xử lý`
  + Thử 9 -> Cả 2 cách đều in `Không xác định`
  + *Vai trò của break:* Dừng lệnh switch ngay sau khi tìm thấy case đúng, tránh bị in tràn xuống dưới.
- **Nhiệm vụ 3 (Danh sách đánh số):**
  + Số lượng = 0 -> Cả for và while đều không in dòng nào.
  + Số lượng = 1 -> In 1 dòng: `Công việc 1`.
  + Số lượng = 5 -> In 5 dòng: từ `Công việc 1` đến `Công việc 5`.
  + *Khi nào while dừng:* Dừng khi biến $i$ tăng vượt quá số lượng ($i = $soLuong + 1).

## 3. Bảng kiểm thử tích hợp (project_tich_hop.php)

Nhóm chọn tích hợp **Switch** (Nhiệm vụ 2) và **For** (Nhiệm vụ 3):

Khi trạng thái là 1 (Mới tạo):  
+ Số lượng = 0: Hiện "Mới tạo", không có dòng công việc nào hiện ra (đúng yêu cầu).   
+ Số lượng = 1: Hiện "Mới tạo", danh sách in ra đúng 1 dòng: Công việc 1.  
+ Số lượng = 5: Hiện "Mới tạo", danh sách in đủ 5 dòng từ Công việc 1 đến Công việc 5.  
Khi trạng thái là 2 (Đang xử lý):  
+ Số lượng = 0: Hiện "Đang xử lý", không có dòng công việc.  
+ Số lượng = 1: Hiện "Đang xử lý", in ra 1 dòng: Công việc 1.  
+ Số lượng = 5: Hiện "Đang xử lý", in ra đủ 5 dòng từ 1 đến 5.   Khi trạng thái là 9 (Giá trị khác/Default):  
+ Số lượng = 0: Hiện "Không xác định", không có dòng công việc.  
+ Số lượng = 1: Hiện "Không xác định", in 1 dòng Công việc 1.  
+ Số lượng = 5: Hiện "Không xác định", in đủ 5 dòng từ 1 đến 5.  
=> Cả 9 trường hợp chạy thử đều khớp đúng kết quả mong đợi, nhãn trạng thái đổi chuẩn và vòng lặp dừng đúng số lượng yêu cầu

## 4. Khó khăn và cách sửa
- Quên tăng `$i++` trong vòng while khiến trang bị đơ vì lặp vô hạn -> Luôn đặt `$i++` trước khi đóng ngoặc while.
- Link repo GitHub nhóm: https://github.com/lekieuanhsm-prog/ICT0025_K64CNTT_Nhom02