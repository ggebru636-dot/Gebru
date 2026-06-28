<?php
// admin/news_delete.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: /admin/news_list.php');
    exit;
}
$id = (int)$_GET['id'];
// delete image file if exists
$stmt = $pdo->prepare('SELECT image FROM news WHERE id = :id');
$stmt->execute([':id'=>$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row && !empty($row['image'])) {
    $path = __DIR__ . '/../' . $row['image'];
    if (file_exists($path)) @unlink($path);
}
$pdo->prepare('DELETE FROM news WHERE id = :id')->execute([':id'=>$id]);
header('Location: /admin/news_list.php');
exit;
