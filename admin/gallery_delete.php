<?php
// admin/gallery_delete.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id !== 0) {
    $pdo->prepare('DELETE FROM gallery WHERE id = ?')->execute([$id]);
}

header('Location: /admin/gallery_list.php');
exit;
