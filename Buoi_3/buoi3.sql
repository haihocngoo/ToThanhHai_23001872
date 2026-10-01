
CREATE TABLE IF NOT EXISTS cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO cart_items (name, price, quantity) VALUES
    ('Laptop', 15000000.00, 1),
    ('Chuot khong day', 350000.00, 8),
    ('Ban phim', 750000.00, 4),
    ('Tai nghe', 600000.00, 6),
    ('USB 64GB', 95000.00, 10);

SELECT *
FROM cart_items;

SELECT *
FROM cart_items
WHERE price > 100000;

SELECT *
FROM cart_items
WHERE quantity > 5;

SELECT *
FROM cart_items
ORDER BY price DESC;

UPDATE cart_items
SET price = 400000.00
WHERE id = 2;

UPDATE cart_items
SET quantity = 7
WHERE id = 3;

DELETE FROM cart_items
WHERE id = 5;

SELECT
    name,
    price,
    quantity,
    price * quantity AS total_price
FROM cart_items;

SELECT SUM(price * quantity) AS cart_total
FROM cart_items;

CREATE TABLE IF NOT EXISTS movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

INSERT INTO movies (title, price, total_seats, available_seats) VALUES
    ('Avengers', 100000.00, 100, 70),
    ('Avatar', 120000.00, 80, 40),
    ('Batman', 90000.00, 120, 90),
    ('Spider-Man', 110000.00, 100, 55),
    ('The Lion King', 85000.00, 90, 65);

SELECT *
FROM movies;

SELECT *
FROM movies
WHERE price > 100000;

SELECT *
FROM movies
WHERE available_seats > 50;

SELECT *
FROM movies
ORDER BY price DESC;

UPDATE movies
SET available_seats = 60
WHERE id = 1;

DELETE FROM movies
WHERE id = 5;

SELECT
    title,
    total_seats - available_seats AS sold_seats
FROM movies;

SELECT
    title,
    (total_seats - available_seats) * price AS revenue
FROM movies;

SELECT SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;

SELECT
    title,
    total_seats - available_seats AS sold_seats
FROM movies
WHERE total_seats - available_seats = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);
