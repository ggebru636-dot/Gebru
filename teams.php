<?php
// teams.php (Teams list)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Teams';
require_once __DIR__ . '/inc/header.php';

$teams = $pdo->query('SELECT id,name,slug,logo,description FROM teams ORDER BY name ASC')->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h1>Our Teams</h1>
  
  <?php if (empty($teams)): ?>
    <div class="alert alert-info">No teams yet. Check back soon!</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($teams as $t): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100">
            <?php if ($t['logo']): ?>
              <img src="<?=htmlspecialchars($t['logo'])?>" class="card-img-top" alt="<?=htmlspecialchars($t['name'])?>">
            <?php else: ?>
              <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
                <span style="color:#999;">Team Logo</span>
              </div>
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($t['name'])?></h5>
              <p class="card-text"><?=htmlspecialchars(substr($t['description'] ?? '', 0, 100))?><?= strlen($t['description'] ?? '') > 100 ? '...' : '' ?></p>
              <a href="/team.php?id=<?=urlencode($t['slug'])?>" class="btn btn-sm btn-primary">View Team</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
