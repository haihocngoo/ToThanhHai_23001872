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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (productId($_POST['id'] ?? null) !== $id) {
        http_response_code(400);
        exit('Yêu cầu không hợp lệ.');
    }
    deleteProduct($id);
    header('Location: product_list.php?message=deleted');
    exit;
}
require __DIR__ . '/view/header.php';
?>
<h2>Xác nhận xóa</h2>
<p>Bạn có chắc muốn xóa sản phẩm <strong><?= escapeHtml($product['name']) ?></strong> (ID <?= $id ?>)?</p>
<form method="post" action="product_delete.php?id=<?= $id ?>">
    <input type="hidden" name="id" value="<?= $id ?>">
    <button type="submit">Xác nhận xóa</button>
    <a href="product_list.php">Hủy</a>
</form>
<?php require __DIR__ . '/view/footer.php'; ?>
