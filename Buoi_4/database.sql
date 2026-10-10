CREATE DATABASE IF NOT EXISTS shopping_cart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Bàn phím', 250000.00, 10),
('Chuột máy tính', 150000.00, 15),
('Tai nghe', 350000.00, 8),
('Màn hình', 2800000.00, 5),
('USB 32GB', 120000.00, 20);
