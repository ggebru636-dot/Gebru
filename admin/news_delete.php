<?php
// admin/news_delete.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id !== 0) {
    $pdo->prepare('DELETE FROM news WHERE id = ?')->execute([$id]);
}

header('Location: /admin/news_list.php');
exit;
