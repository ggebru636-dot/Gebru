<?php
// admin/memberships_list.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$memberships = $pdo->query('SELECT id,name,email,phone,membership_type,status,payment_status,created_at FROM memberships ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Memberships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Manage Memberships</h1>
    <p><a href="/admin/" class="btn btn-secondary">Back</a></p>
    
    <?php if (empty($memberships)): ?>
      <div class="alert alert-info">No memberships yet.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead><tr><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Payment</th><th>Date</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($memberships as $m): ?>
              <tr>
                <td><?=htmlspecialchars($m['name'])?></td>
                <td><a href="mailto:<?=htmlspecialchars($m['email'])?>"><?=htmlspecialchars($m['email'])?></a></td>
                <td><?=htmlspecialchars(ucfirst($m['membership_type']))?></td>
                <td><span class="badge <?= $m['status'] === 'approved' ? 'bg-success' : 'bg-warning' ?>"><?=ucfirst($m['status'])?></span></td>
                <td><span class="badge <?= $m['payment_status'] === 'paid' ? 'bg-success' : 'bg-secondary' ?>"><?=ucfirst($m['payment_status'])?></span></td>
                <td><?=date('M d, Y', strtotime($m['created_at']))?></td>
                <td><a href="/admin/membership_view.php?id=<?=$m['id']?>" class="btn btn-xs btn-primary">View</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
  </body>
</html>
