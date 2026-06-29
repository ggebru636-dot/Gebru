<?php
// gallery.php (Gallery/Media page)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Gallery & Media';
require_once __DIR__ . '/inc/header.php';

$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

$total = $pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn();
$pages = ceil($total / $per_page);

$gallery = $pdo->query("SELECT id,title,description,image_url,media_type,created_at FROM gallery ORDER BY created_at DESC LIMIT $per_page OFFSET $offset")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h1>Gallery & Media</h1>
  <p class="text-muted">Explore photos and videos from our events and activities.</p>
  
  <?php if (empty($gallery)): ?>
    <div class="alert alert-info">No media yet. Check back soon!</div>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($gallery as $item): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 cursor-pointer" data-bs-toggle="modal" data-bs-target="#mediaModal<?=$item['id']?>">
            <img src="<?=htmlspecialchars($item['image_url'])?>" class="card-img-top" alt="<?=htmlspecialchars($item['title'])?>' style="height:250px; object-fit:cover;">
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($item['title'])?></h5>
              <p class="card-text"><small class="text-muted"><?=date('M d, Y', strtotime($item['created_at']))?></small></p>
              <?php if ($item['description']): ?>
                <p class="card-text"><small><?=htmlspecialchars(substr($item['description'], 0, 60))?><?= strlen($item['description']) > 60 ? '...' : '' ?></small></p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="mediaModal<?=$item['id']?>" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?=htmlspecialchars($item['title'])?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body text-center">
                <img src="<?=htmlspecialchars($item['image_url'])?>" class="img-fluid" alt="<?=htmlspecialchars($item['title'])?>">
                <?php if ($item['description']): ?>
                  <p class="mt-3"><?=htmlspecialchars($item['description'])?></p>
                <?php endif; ?>
              </div>
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
