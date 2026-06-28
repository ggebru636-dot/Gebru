<?php
// admin/events_list.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$items = $pdo->query('SELECT id,title,start_at FROM events ORDER BY start_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Events</h1>
    <p><a href="/admin/event_edit.php" class="btn btn-success">New event</a> <a href="/admin/" class="btn btn-secondary">Back</a></p>
    <table class="table table-striped">
      <thead><tr><th>Title</th><th>Start</th><th></th></tr></thead>
      <tbody>
        <?php foreach($items as $it): ?>
          <tr>
            <td><?=htmlspecialchars($it['title'])?></td>
            <td><?=htmlspecialchars($it['start_at'])?></td>
            <td>
              <a href="/admin/event_edit.php?id=<?=$it['id']?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="/admin/event_delete.php?id=<?=$it['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </body>
</html>
