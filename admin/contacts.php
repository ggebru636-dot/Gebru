<?php
// admin/contacts.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$contacts = $pdo->query('SELECT id,name,email,message,created_at FROM contacts ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Contacts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Contact messages</h1>
    <p><a href="/admin/export_contacts.php" class="btn btn-sm btn-primary">Export CSV</a> <a href="/admin/" class="btn btn-secondary">Back</a></p>
    <?php if (empty($contacts)): ?>
      <div class="alert alert-info">No contact messages yet.</div>
    <?php else: ?>
      <table class="table table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach($contacts as $c): ?>
          <tr>
            <td><?=htmlspecialchars($c['name'])?></td>
            <td><?=htmlspecialchars($c['email'])?></td>
            <td><?=nl2br(htmlspecialchars($c['message']))?></td>
            <td><?=htmlspecialchars($c['created_at'])?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
  </body>
</html>
