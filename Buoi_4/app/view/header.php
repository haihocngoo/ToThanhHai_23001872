<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
    <h1>Quản lý sản phẩm</h1>
    <?php if (isset($_SESSION['user_id'], $_SESSION['username'])): ?>
        <nav><a href="product_list.php">Danh sách</a> | <a href="product_add.php">Thêm sản phẩm</a> | Tài khoản: <?= escapeHtml($_SESSION['username']) ?> | <a href="logout.php">Đăng xuất</a></nav>
    <?php endif; ?>
