<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/common/helpers.php';
require_once __DIR__ . '/model/user.php';
startUserSession();
if (isset($_SESSION['user_id'])) {
    header('Location: product_list.php');
    exit;
}
$error = '';
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if ($username === '' || $password === '') {
        $error = 'Tên đăng nhập và mật khẩu không được để trống.';
    } else {
        $user = getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        }
        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}
require __DIR__ . '/view/header.php';
?>
<h2>Đăng nhập</h2>
<?php if (isset($_GET['registered'])): ?><p class="success">Đăng ký thành công. Vui lòng đăng nhập.</p><?php endif; ?>
<?php if ($error !== ''): ?><p class="error"><?= escapeHtml($error) ?></p><?php endif; ?>
<form method="post">
    <label>Tên đăng nhập <input name="username" required autocomplete="username" value="<?= escapeHtml($username) ?>"></label>
    <label>Mật khẩu <input type="password" name="password" required autocomplete="current-password"></label>
    <button type="submit">Đăng nhập</button>
</form>
<p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
<?php require __DIR__ . '/view/footer.php'; ?>
