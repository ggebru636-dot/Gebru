<?php
// admin/gallery_list.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$gallery = $pdo->query('SELECT id,title,description,image_url,media_type,created_at FROM gallery ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Manage Gallery</h1>
    <p><a href="/admin/gallery_add.php" class="btn btn-primary">Add Media</a> <a href="/admin/" class="btn btn-secondary">Back</a></p>
    
    <?php if (empty($gallery)): ?>
      <div class="alert alert-info">No gallery items yet.</div>
    <?php else: ?>
      <table class="table table-striped">
        <thead><tr><th>Title</th><th>Type</th><th>Image</th><th>Added</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($gallery as $item): ?>
            <tr>
              <td><?=htmlspecialchars($item['title'])?></td>
              <td><?=htmlspecialchars(ucfirst($item['media_type']))?></td>
              <td><img src="<?=htmlspecialchars($item['image_url'])?>" style="max-height:50px;"></td>
              <td><?=date('M d, Y', strtotime($item['created_at']))?></td>
              <td>
                <a href="/admin/gallery_delete.php?id=<?=$item['id']?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
  </body>
</html>
