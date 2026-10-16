<?php
declare(strict_types=1);

function startUserSession(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function requireLogin(): void
{
    startUserSession();
    if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }
}
