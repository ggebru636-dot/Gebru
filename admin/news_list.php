<?php
// admin/news_list.php (News CMS list)
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

$total = $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
$pages = ceil($total / $per_page);

$news = $pdo->query("SELECT id,title,slug,content,image,created_at FROM news ORDER BY created_at DESC LIMIT $per_page OFFSET $offset")->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Manage News & Announcements</h1>
    <p><a href="/admin/news_add.php" class="btn btn-primary">Add News</a> <a href="/admin/" class="btn btn-secondary">Back</a></p>
    
    <?php if (empty($news)): ?>
      <div class="alert alert-info">No news articles yet.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead><tr><th>Title</th><th>Image</th><th>Published</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($news as $n): ?>
              <tr>
                <td><?=htmlspecialchars($n['title'])?></td>
                <td><?= $n['image'] ? '✓' : '—' ?></td>
                <td><?=date('M d, Y', strtotime($n['created_at']))?></td>
                <td>
                  <a href="/admin/news_edit.php?id=<?=$n['id']?>" class="btn btn-xs btn-warning">Edit</a>
                  <a href="/admin/news_delete.php?id=<?=$n['id']?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

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
