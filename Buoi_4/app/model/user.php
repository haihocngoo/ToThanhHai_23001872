<?php
declare(strict_types=1);
require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername(string $username): array|false
{
    $statement = dbConnect()->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $statement->execute([$username]);
    return $statement->fetch();
}

function addUser(string $username, string $passwordHash): bool
{
    $statement = dbConnect()->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    return $statement->execute([$username, $passwordHash]);
}
