<?php
// admin/news_list.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$posts = $pdo->query('SELECT id,title,created_at FROM news ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>News</h1>
    <p><a href="/admin/news_edit.php" class="btn btn-success">New article</a> <a href="/admin/" class="btn btn-secondary">Back</a></p>
    <table class="table table-striped">
      <thead><tr><th>Title</th><th>Date</th><th></th></tr></thead>
      <tbody>
        <?php foreach($posts as $p): ?>
          <tr>
            <td><?=htmlspecialchars($p['title'])?></td>
            <td><?=htmlspecialchars($p['created_at'])?></td>
            <td>
              <a href="/admin/news_edit.php?id=<?=$p['id']?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="/admin/news_delete.php?id=<?=$p['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </body>
</html>
