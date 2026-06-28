<?php
// inc/auth.php
session_start();
require_once __DIR__ . '/db.php';

function admin_login($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :u LIMIT 1');
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
        // regenerate session id
        session_regenerate_id(true);
        $_SESSION['admin_user'] = ['id' => $user['id'], 'username' => $user['username']];
        return true;
    }
    return false;
}

function require_admin() {
    if (empty($_SESSION['admin_user'])) {
        header('Location: /admin/login.php');
        exit;
    }
}

function admin_logout() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}
