<?php
declare(strict_types=1);

function dbConnect(): PDO
{
    static $connection = null;
    if ($connection instanceof PDO) {
        return $connection;
    }

    try {
        $connection = new PDO(
            'mysql:host=localhost;dbname=shopping_cart;charset=utf8mb4',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
        return $connection;
    } catch (PDOException $exception) {
        http_response_code(500);
        exit('Không thể kết nối cơ sở dữ liệu. Kiểm tra MySQL và file common/dbConnect.php.');
    }
}
