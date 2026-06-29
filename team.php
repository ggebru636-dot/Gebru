<?php
// team.php (Individual team profile)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Team Profile';
require_once __DIR__ . '/inc/header.php';

$slug = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($slug === '') {
    header('Location: /teams.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM teams WHERE slug = :slug');
$stmt->execute([':slug'=>$slug]);
$team = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$team) {
    echo '<div class="container my-5"><div class="alert alert-danger">Team not found.</div></div>';
    require_once __DIR__ . '/inc/footer.php';
    exit;
}

$players = $pdo->prepare('SELECT * FROM players WHERE team_id = :id ORDER BY number ASC')->execute([':id'=>$team['id']]);
$stmt = $pdo->prepare('SELECT * FROM players WHERE team_id = :id ORDER BY number ASC');
$stmt->execute([':id'=>$team['id']]);
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

$standings = $pdo->prepare('SELECT * FROM standings WHERE team_id = :id')->execute([':id'=>$team['id']]);
$stmt = $pdo->prepare('SELECT * FROM standings WHERE team_id = :id');
$stmt->execute([':id'=>$team['id']]);
$standings = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <div class="row mb-4">
    <div class="col-md-3">
      <?php if ($team['logo']): ?>
        <img src="<?=htmlspecialchars($team['logo'])?>" class="img-fluid" alt="<?=htmlspecialchars($team['name'])?>">
      <?php else: ?>
        <div style="width:100%; height:300px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
          <span style="color:#999;">Team Logo</span>
        </div>
      <?php endif; ?>
    </div>
    <div class="col-md-9">
      <h1><?=htmlspecialchars($team['name'])?></h1>
      <p><?=nl2br(htmlspecialchars($team['description'] ?? 'No description provided'))?></p>
      
      <?php if ($standings): ?>
        <div class="card mt-3">
          <div class="card-body">
            <h5 class="card-title">Season Stats</h5>
            <p><strong>Wins:</strong> <?=$standings['wins']?></p>
            <p><strong>Losses:</strong> <?=$standings['losses']?></p>
            <p><strong>Points:</strong> <?=$standings['points']?></p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Players -->
  <h2>Team Roster</h2>
  <?php if (empty($players)): ?>
    <div class="alert alert-info">No players listed yet.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($players as $p): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card">
            <?php if ($p['photo']): ?>
              <img src="<?=htmlspecialchars($p['photo'])?>" class="card-img-top" alt="<?=htmlspecialchars($p['name'])?>">
            <?php else: ?>
              <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:48px;">
                #<?=$p['number'] ?? '?'?>
              </div>
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($p['name'])?></h5>
              <p class="card-text">
                <strong>#<?=$p['number'] ?? 'N/A'?></strong><br>
                <small><?=htmlspecialchars(ucfirst($p['position'] ?? 'Position TBD'))?></small>
              </p>
              <?php if ($p['bio']): ?>
                <p class="card-text"><small><?=htmlspecialchars(substr($p['bio'], 0, 60))?><?= strlen($p['bio']) > 60 ? '...' : '' ?></small></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <a href="/teams.php" class="btn btn-outline-primary mt-4">← Back to Teams</a>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
