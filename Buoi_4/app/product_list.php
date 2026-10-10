<?php
require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/helpers.php';
$products = getAllProducts();
require __DIR__ . '/view/header.php';
?>
<h2>Danh sách sản phẩm</h2>
<?php if (isset($_GET['message'])): ?>
    <?php $messages = ['added' => 'Đã thêm sản phẩm.', 'updated' => 'Đã cập nhật sản phẩm.', 'deleted' => 'Đã xóa sản phẩm.']; ?>
    <?php if (isset($messages[$_GET['message']])): ?><p class="success"><?= escapeHtml($messages[$_GET['message']]) ?></p><?php endif; ?>
<?php endif; ?>
<table>
    <thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Chức năng</th></tr></thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= escapeHtml($product['id']) ?></td>
            <td><?= escapeHtml($product['name']) ?></td>
            <td><?= number_format((float) $product['price'], 2, ',', '.') ?></td>
            <td><?= escapeHtml($product['quantity']) ?></td>
            <td><a href="product_edit.php?id=<?= (int) $product['id'] ?>">Sửa</a> | <a href="product_delete.php?id=<?= (int) $product['id'] ?>">Xóa</a></td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$products): ?><tr><td colspan="5">Chưa có sản phẩm.</td></tr><?php endif; ?>
    </tbody>
</table>
<?php require __DIR__ . '/view/footer.php'; ?>
