<?php
// admin/contacts_actions.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/contacts.php');
    exit;
}

$id = isset($_POST['id']) && ctype_digit($_POST['id']) ? (int)$_POST['id'] : 0;
$action = $_POST['action'] ?? '';
$filter = $_POST['filter'] ?? 'active';

if ($id === 0) {
    header('Location: /admin/contacts.php');
    exit;
}

if ($action === 'archive') {
    $pdo->prepare('UPDATE contacts SET archived = 1 WHERE id = :id')->execute([':id'=>$id]);
} elseif ($action === 'unarchive') {
    $pdo->prepare('UPDATE contacts SET archived = 0 WHERE id = :id')->execute([':id'=>$id]);
} elseif ($action === 'delete') {
    $pdo->prepare('DELETE FROM contacts WHERE id = :id')->execute([':id'=>$id]);
}

header('Location: /admin/contacts.php?filter=' . htmlspecialchars($filter));
exit;
