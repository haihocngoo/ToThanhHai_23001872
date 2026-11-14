<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

header('Content-Type: application/json; charset=utf-8');

function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function readJson(): array
{
    $raw = file_get_contents('php://input');
    try {
        $data = json_decode($raw === false ? '' : $raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        respond(400, ['success' => false, 'message' => 'JSON không hợp lệ.']);
    }
    if (!is_array($data) || array_is_list($data)) {
        respond(400, ['success' => false, 'message' => 'Dữ liệu phải là một đối tượng JSON.']);
    }
    return $data;
}

function validatedProduct(array $data): array
{
    $name = $data['name'] ?? null;
    $price = $data['price'] ?? null;
    $stock = $data['stock'] ?? null;

    if (!is_string($name) || trim($name) === '') {
        respond(400, ['success' => false, 'message' => 'Tên sản phẩm phải có từ 1 đến 100 ký tự.']);
    }
    $name = trim($name);
    if (mb_strlen($name, 'UTF-8') > 100) {
        respond(400, ['success' => false, 'message' => 'Tên sản phẩm phải có từ 1 đến 100 ký tự.']);
    }
    if (!is_int($price) || $price <= 0 || $price > 2147483647) {
        respond(400, ['success' => false, 'message' => 'Đơn giá phải là số nguyên lớn hơn 0.']);
    }
    if (!is_int($stock) || $stock < 0 || $stock > 2147483647) {
        respond(400, ['success' => false, 'message' => 'Số lượng tồn phải là số nguyên không âm.']);
    }
    return [$name, $price, $stock];
}

function requestedId(): int
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 2147483647]]);
    if ($id === false || $id === null) {
        respond(400, ['success' => false, 'message' => 'Mã sản phẩm không hợp lệ.']);
    }
    return $id;
}

function productById(PDO $connection, int $id): array|false
{
    $statement = $connection->prepare('SELECT id, name, price, stock FROM products WHERE id = ?');
    $statement->execute([$id]);
    return $statement->fetch();
}

function normalizedProduct(array $product): array
{
    return [
        'id' => (int) $product['id'],
        'name' => $product['name'],
        'price' => (int) $product['price'],
        'stock' => (int) $product['stock'],
    ];
}

try {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
        header('Allow: GET, POST, PUT, DELETE');
        respond(405, ['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
    }

    if ($method === 'GET') {
        $products = db()->query('SELECT id, name, price, stock FROM products ORDER BY id DESC')->fetchAll();
        respond(200, ['success' => true, 'data' => array_map('normalizedProduct', $products)]);
    }

    if ($method === 'POST') {
        [$name, $price, $stock] = validatedProduct(readJson());
        $connection = db();
        $statement = $connection->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
        $statement->execute([$name, $price, $stock]);
        $id = (int) $connection->lastInsertId();
        respond(201, ['success' => true, 'data' => normalizedProduct(productById($connection, $id))]);
    }

    $id = requestedId();
    $connection = db();
    if (!productById($connection, $id)) {
        respond(404, ['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);
    }

    if ($method === 'PUT') {
        [$name, $price, $stock] = validatedProduct(readJson());
        $statement = $connection->prepare('UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?');
        $statement->execute([$name, $price, $stock, $id]);
        respond(200, ['success' => true, 'data' => normalizedProduct(productById($connection, $id))]);
    }

    $statement = $connection->prepare('DELETE FROM products WHERE id = ?');
    $statement->execute([$id]);
    respond(200, ['success' => true, 'message' => 'Đã xóa sản phẩm.']);
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    respond(500, ['success' => false, 'message' => 'Lỗi cơ sở dữ liệu. Kiểm tra cấu hình MySQL.']);
}
