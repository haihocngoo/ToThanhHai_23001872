<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/helpers.php';
$errors = [];
$data = ['name' => '', 'price' => '', 'quantity' => '0'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken($_POST['csrf_token'] ?? null);
    $data = $_POST;
    [$errors, $name, $price, $quantity] = validateProduct($data);
    if (!$errors) {
        addProduct($name, $price, $quantity);
        header('Location: product_list.php?message=added');
        exit;
    }
}
require __DIR__ . '/view/header.php';
?>
<h2>Thêm sản phẩm</h2>
<?php foreach ($errors as $error): ?><p class="error"><?= escapeHtml($error) ?></p><?php endforeach; ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= escapeHtml(csrfToken()) ?>">
    <label>Tên sản phẩm <input name="name" maxlength="100" required value="<?= escapeHtml($data['name'] ?? '') ?>"></label>
    <label>Giá <input type="number" name="price" min="0.01" max="99999999.99" step="0.01" required value="<?= escapeHtml($data['price'] ?? '') ?>"></label>
    <label>Số lượng <input type="number" name="quantity" min="0" step="1" required value="<?= escapeHtml($data['quantity'] ?? '') ?>"></label>
    <button type="submit">Thêm</button>
</form>
<?php require __DIR__ . '/view/footer.php'; ?>
