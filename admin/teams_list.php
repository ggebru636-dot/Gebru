<?php
// admin/teams_list.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$teams = $pdo->query('SELECT id,name,slug,logo,description,created_at FROM teams ORDER BY name ASC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Teams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Manage Teams</h1>
    <p><a href="/admin/team_add.php" class="btn btn-primary">Add Team</a> <a href="/admin/" class="btn btn-secondary">Back</a></p>
    
    <?php if (empty($teams)): ?>
      <div class="alert alert-info">No teams yet. Create one to get started.</div>
    <?php else: ?>
      <table class="table table-striped">
        <thead><tr><th>Name</th><th>Slug</th><th>Logo</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($teams as $t): ?>
            <tr>
              <td><?=htmlspecialchars($t['name'])?></td>
              <td><?=htmlspecialchars($t['slug'])?></td>
              <td><?= $t['logo'] ? '✓' : '—' ?></td>
              <td>
                <a href="/admin/team_edit.php?id=<?=$t['id']?>" class="btn btn-xs btn-warning">Edit</a>
                <a href="/admin/team_delete.php?id=<?=$t['id']?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
  </body>
</html>
