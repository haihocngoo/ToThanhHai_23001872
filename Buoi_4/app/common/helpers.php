<?php
declare(strict_types=1);

function escapeHtml(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function validateProduct(array $input): array
{
    $name = trim((string) ($input['name'] ?? ''));
    $price = trim((string) ($input['price'] ?? ''));
    $quantity = trim((string) ($input['quantity'] ?? ''));
    $errors = [];

    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm tối đa 100 ký tự.';
    }
    if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/D', $price) || (float) $price <= 0) {
        $errors[] = 'Giá phải lớn hơn 0, tối đa 8 chữ số trước dấu chấm và 2 chữ số thập phân.';
    }
    if (filter_var($quantity, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 2147483647]]) === false) {
        $errors[] = 'Số lượng phải là số nguyên không âm.';
    }
    return [$errors, $name, $price, (int) $quantity];
}

function productId(mixed $value): int
{
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? 0 : $id;
}

function csrfToken(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(mixed $token): void
{
    if (!is_string($token) || !hash_equals(csrfToken(), $token)) {
        http_response_code(400);
        exit('Yêu cầu không hợp lệ. Vui lòng tải lại trang và thử lại.');
    }
}
