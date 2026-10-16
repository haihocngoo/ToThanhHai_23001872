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
    } elseif (mb_strlen($username, 'UTF-8') > 50) {
        $error = 'Tên đăng nhập tối đa 50 ký tự.';
    } elseif (getUserByUsername($username)) {
        $error = 'Tên đăng nhập đã tồn tại.';
    } else {
        try {
            addUser($username, password_hash($password, PASSWORD_DEFAULT));
            header('Location: login.php?registered=1');
            exit;
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                $error = 'Tên đăng nhập đã tồn tại.';
            } else {
                throw $exception;
            }
        }
    }
}
require __DIR__ . '/view/header.php';
?>
<h2>Đăng ký</h2>
<?php if ($error !== ''): ?><p class="error"><?= escapeHtml($error) ?></p><?php endif; ?>
<form method="post">
    <label>Tên đăng nhập <input name="username" maxlength="50" required autocomplete="username" value="<?= escapeHtml($username) ?>"></label>
    <label>Mật khẩu <input type="password" name="password" required autocomplete="new-password"></label>
    <button type="submit">Đăng ký</button>
</form>
<p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
<?php require __DIR__ . '/view/footer.php'; ?>
