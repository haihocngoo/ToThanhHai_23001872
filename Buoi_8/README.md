# Bài thực hành 8 - PHP API và Vue.js

## Cài đặt bằng XAMPP

1. Chép thư mục `Buoi_8` vào `htdocs` (hoặc clone toàn bộ repo vào `htdocs`).
2. Khởi động Apache và MySQL. Import `database.sql` bằng phpMyAdmin **một lần**; file tạo database `buoi_8`, bảng `products` và ba dòng mẫu.
3. Nếu MySQL dùng tài khoản khác `root` hoặc có mật khẩu, cấu hình các biến môi trường `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` cho Apache, hoặc sửa giá trị mặc định trong `api/db.php`.
4. Mở `http://localhost/Buoi_8/index.html` (nếu clone cả repo, thêm tên thư mục repo vào URL). Vue được tải từ CDN nên cần Internet. **Không mở trang bằng `file://`**, vì khi đó PHP API sẽ không chạy.

Yêu cầu PHP 8.1 trở lên, extension PDO MySQL và mbstring. API ở `api/products.php`:

| Phương thức | Đường dẫn | Chức năng |
| --- | --- | --- |
| GET | `api/products.php` | Danh sách trong `data` |
| POST | `api/products.php` | Thêm sản phẩm từ JSON |
| PUT | `api/products.php?id=1` | Cập nhật theo ID |
| DELETE | `api/products.php?id=1` | Xóa theo ID |

Ví dụ kiểm tra trực tiếp dữ liệu không hợp lệ (API phải trả HTTP 400 và `success: false`):

```bash
curl -i -X POST http://localhost/Buoi_8/api/products.php -H "Content-Type: application/json" -d '{"name":"Bút mới","price":5000,"stock":-1}'
```

Sau khi thêm, sửa hoặc xóa trên giao diện, ứng dụng gọi lại GET API. Tải lại trang vẫn thấy dữ liệu đã lưu trong MySQL.
