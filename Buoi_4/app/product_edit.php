<?php
require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/helpers.php';
$id = productId($_GET['id'] ?? null);
$product = $id ? getProductById($id) : false;
if (!$product) {
    http_response_code(404);
    require __DIR__ . '/view/header.php';
    echo '<p class="error">Không tìm thấy sản phẩm.</p>';
    require __DIR__ . '/view/footer.php';
    exit;
}
$errors = [];
$data = $product;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    [$errors, $name, $price, $quantity] = validateProduct($data);
    if (!$errors) {
        updateProduct($id, $name, $price, $quantity);
        header('Location: product_list.php?message=updated');
        exit;
    }
}
require __DIR__ . '/view/header.php';
?>
<h2>Sửa sản phẩm #<?= $id ?></h2>
<?php foreach ($errors as $error): ?><p class="error"><?= escapeHtml($error) ?></p><?php endforeach; ?>
<form method="post" action="product_edit.php?id=<?= $id ?>">
    <label>Tên sản phẩm <input name="name" maxlength="100" required value="<?= escapeHtml($data['name'] ?? '') ?>"></label>
    <label>Giá <input type="number" name="price" min="0.01" max="99999999.99" step="0.01" required value="<?= escapeHtml($data['price'] ?? '') ?>"></label>
    <label>Số lượng <input type="number" name="quantity" min="0" step="1" required value="<?= escapeHtml($data['quantity'] ?? '') ?>"></label>
    <button type="submit">Lưu thay đổi</button>
</form>
<?php require __DIR__ . '/view/footer.php'; ?>
