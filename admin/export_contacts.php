<?php
// admin/export_contacts.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['active','archived']) ? $_GET['filter'] : 'active';

$where = '';
if ($filter === 'active') $where = 'WHERE archived = 0';
if ($filter === 'archived') $where = 'WHERE archived = 1';

$query = "SELECT id,name,email,message,archived,created_at FROM contacts $where ORDER BY created_at DESC";
$stmt = $pdo->query($query);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filename = 'contacts-' . date('Ymd-His') . '.csv';
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$fp = fopen('php://output', 'w');
// BOM for UTF-8 to help Excel
fwrite($fp, "\xEF\xBB\xBF");
// header
fputcsv($fp, ['id','name','email','message','archived','created_at']);
foreach ($rows as $r) {
    $r['message'] = str_replace("\r\n", "\n", $r['message']);
    fputcsv($fp, [$r['id'],$r['name'],$r['email'],$r['message'],$r['archived'],$r['created_at']]);
}
fclose($fp);
exit;
