<?php
// admin/newsletter_list.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 50;
$offset = ($page - 1) * $per_page;

$total = $pdo->query('SELECT COUNT(*) FROM newsletter_subscribers WHERE unsubscribed_at IS NULL')->fetchColumn();
$pages = ceil($total / $per_page);

$subscribers = $pdo->query("SELECT id,email,subscribed_at FROM newsletter_subscribers WHERE unsubscribed_at IS NULL ORDER BY subscribed_at DESC LIMIT $per_page OFFSET $offset")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Newsletter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Newsletter Subscribers</h1>
    <p>Total active subscribers: <strong><?=$total?></strong></p>
    <p><a href="/admin/" class="btn btn-secondary">Back</a></p>
    
    <?php if (empty($subscribers)): ?>
      <div class="alert alert-info">No subscribers yet.</div>
    <?php else: ?>
      <table class="table table-striped">
        <thead><tr><th>Email</th><th>Subscribed</th></tr></thead>
        <tbody>
          <?php foreach ($subscribers as $sub): ?>
            <tr>
              <td><?=htmlspecialchars($sub['email'])?></td>
              <td><?=date('M d, Y', strtotime($sub['subscribed_at']))?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <?php if ($pages > 1): ?>
        <nav aria-label="Pagination">
          <ul class="pagination">
            <?php if ($page > 1): ?>
              <li class="page-item"><a class="page-link" href="?page=<?=$page-1?>">Previous</a></li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Previous</span></li>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $pages; $i++): ?>
              <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?=$i?>"><?=$i?></a></li>
            <?php endfor; ?>
            
            <?php if ($page < $pages): ?>
              <li class="page-item"><a class="page-link" href="?page=<?=$page+1?>">Next</a></li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Next</span></li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  </body>
</html>
