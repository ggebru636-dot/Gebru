<?php
// admin/event_delete.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: /admin/events_list.php');
    exit;
}
$id = (int)$_GET['id'];
$pdo->prepare('DELETE FROM events WHERE id = :id')->execute([':id'=>$id]);
header('Location: /admin/events_list.php');
exit;
