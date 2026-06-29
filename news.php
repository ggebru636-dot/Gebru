<?php
// news.php (News list)
require_once __DIR__ . '/inc/db.php';
$page_title = 'News & Announcements';
require_once __DIR__ . '/inc/header.php';

$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$total = $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
$pages = ceil($total / $per_page);

$news = $pdo->query("SELECT id,title,slug,content,image,created_at FROM news ORDER BY created_at DESC LIMIT $per_page OFFSET $offset")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h1>News & Announcements</h1>
  
  <?php if (empty($news)): ?>
    <div class="alert alert-info">No news yet.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($news as $n): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100">
            <?php if ($n['image']): ?>
              <img src="<?=htmlspecialchars($n['image'])?>" class="card-img-top" alt="<?=htmlspecialchars($n['title'])?>">
            <?php else: ?>
              <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
                <span style="color:#999;">News Image</span>
              </div>
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($n['title'])?></h5>
              <p class="card-text"><small class="text-muted"><?=date('M d, Y', strtotime($n['created_at']))?></small></p>
              <p class="card-text"><?=htmlspecialchars(substr($n['content'], 0, 120))?><?= strlen($n['content']) > 120 ? '...' : '' ?></p>
              <a href="/news.php?id=<?=$n['id']?>" class="btn btn-sm btn-primary">Read More</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
      <nav aria-label="Pagination" class="mt-4">
        <ul class="pagination justify-content-center">
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

<?php require_once __DIR__ . '/inc/footer.php'; ?>
