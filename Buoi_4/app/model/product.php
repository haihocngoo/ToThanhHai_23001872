<?php
declare(strict_types=1);
require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts(): array
{
    return dbConnect()->query('SELECT id, name, price, quantity FROM products ORDER BY id DESC')->fetchAll();
}

function getProductById(int $id): array|false
{
    $statement = dbConnect()->prepare('SELECT id, name, price, quantity FROM products WHERE id = ?');
    $statement->execute([$id]);
    return $statement->fetch();
}

function addProduct(string $name, string $price, int $quantity): bool
{
    $statement = dbConnect()->prepare('INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)');
    return $statement->execute([$name, $price, $quantity]);
}

function updateProduct(int $id, string $name, string $price, int $quantity): bool
{
    $statement = dbConnect()->prepare('UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?');
    return $statement->execute([$name, $price, $quantity, $id]);
}

function deleteProduct(int $id): bool
{
    $statement = dbConnect()->prepare('DELETE FROM products WHERE id = ?');
    return $statement->execute([$id]);
}
