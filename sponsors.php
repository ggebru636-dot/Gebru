<?php
// sponsors.php (Sponsors & Partners page)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Sponsors & Partners';
require_once __DIR__ . '/inc/header.php';

$sponsors = $pdo->query('SELECT id,name,logo,website,tier,contact_email FROM sponsors ORDER BY tier DESC, name ASC')->fetchAll(PDO::FETCH_ASSOC);

// Group by tier
$tiers = [];
foreach ($sponsors as $s) {
    $tier = $s['tier'] ?? 'bronze';
    if (!isset($tiers[$tier])) $tiers[$tier] = [];
    $tiers[$tier][] = $s;
}
?>

<div class="container my-5">
  <h1>Sponsors & Partners</h1>
  <p>We are grateful to our sponsors and partners who support volleyball in Tigray.</p>
  
  <?php 
  $tier_labels = ['platinum' => 'Platinum', 'gold' => 'Gold', 'silver' => 'Silver', 'bronze' => 'Bronze'];
  foreach ($tier_labels as $tier => $label): 
    if (isset($tiers[$tier])): ?>
      <h2 class="mt-5"><?=$label?> Sponsors</h2>
      <div class="row">
        <?php foreach ($tiers[$tier] as $s): ?>
          <div class="col-md-6 col-lg-<?= $tier === 'platinum' ? 3 : ($tier === 'gold' ? 4 : 6) ?> mb-4 text-center">
            <div class="card h-100">
              <?php if ($s['logo']): ?>
                <img src="<?=htmlspecialchars($s['logo'])?>" class="card-img-top" alt="<?=htmlspecialchars($s['name'])?>' style="height:150px; object-fit:contain; padding:10px;">
              <?php else: ?>
                <div style="width:100%; height:150px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
                  <span style="color:#999;">Logo</span>
                </div>
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?=htmlspecialchars($s['name'])?></h5>
                <?php if ($s['website']): ?>
                  <a href="<?=htmlspecialchars($s['website'])?>" target="_blank" class="btn btn-sm btn-primary">Visit Website</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif;
  endforeach; ?>

  <?php if (empty($sponsors)): ?>
    <div class="alert alert-info mt-4">No sponsors listed yet. Interested in partnering with us? <a href="/contact.php">Contact us</a>.</div>
  <?php endif; ?>

  <div class="mt-5 p-4 bg-light rounded">
    <h3>Become a Sponsor</h3>
    <p>Help support volleyball development in Tigray. Contact us to learn about sponsorship opportunities.</p>
    <a href="/contact.php" class="btn btn-primary">Get in Touch</a>
  </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
