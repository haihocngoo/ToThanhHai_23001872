-- Dùng file này nếu đã có database shopping_cart từ Bài 4.
-- Giữ nguyên dữ liệu sản phẩm hiện có.
USE shopping_cart;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- admin / 123456; hash bcrypt tương thích password_verify().
INSERT INTO users (username, password)
VALUES ('admin', '$2y$12$IOf8JNVxFfAIiv80GwMAIeUyfYSq1icVWlbUQlR54C9OPyojmPeJG')
ON DUPLICATE KEY UPDATE id = id;
