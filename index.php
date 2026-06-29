<?php
// index.php (Home page)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Tigray Volleyball Federation';
require_once __DIR__ . '/inc/header.php';

// Get latest news
$news = $pdo->query('SELECT id,title,slug,content,image,created_at FROM news ORDER BY created_at DESC LIMIT 3')->fetchAll(PDO::FETCH_ASSOC);

// Get upcoming events
$upcoming = $pdo->query("SELECT id,title,home_team,away_team,start_at,location FROM events WHERE status='scheduled' AND start_at > datetime('now') ORDER BY start_at ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Get recent results
$results = $pdo->query("SELECT id,title,home_team,away_team,home_score,away_score,start_at FROM events WHERE status='completed' ORDER BY start_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// Get standings
$standings = $pdo->query("SELECT s.id, t.name, t.slug, s.wins, s.losses, s.points FROM standings s JOIN teams t ON s.team_id = t.id ORDER BY s.points DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<section class="hero bg-light py-5 mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="display-4" style="color: var(--brand);">Tigray Volleyball Federation</h1>
        <p class="lead">Excellence in Sports, Unity in Community</p>
        <p>Join us in promoting volleyball across Tigray. Discover teams, players, events, and become part of the federation.</p>
        <div class="mt-4">
          <a href="/events.php" class="btn btn-primary btn-lg me-2">View Events</a>
          <a href="/teams.php" class="btn btn-outline-primary btn-lg">Our Teams</a>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <div style="width:100%; height:300px; background-color:#e9ecef; border-radius:10px; display:flex; align-items:center; justify-content:center;">
          <span style="color:#999; font-size:14px;">Volleyball Hero Image</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Upcoming Events -->
<?php if (!empty($upcoming)): ?>
<section class="mb-5">
  <div class="container">
    <h2>Upcoming Events</h2>
    <div class="row">
      <?php foreach ($upcoming as $event): ?>
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($event['title'])?></h5>
              <p class="card-text">
                <strong><?=htmlspecialchars($event['home_team'] ?? 'TBD')?> vs <?=htmlspecialchars($event['away_team'] ?? 'TBD')?></strong><br>
                <small class="text-muted"><?=date('M d, Y H:i', strtotime($event['start_at']))?></small><br>
                <small><?=htmlspecialchars($event['location'] ?? 'Location TBD')?></small>
              </p>
              <a href="/event.php?id=<?=$event['id']?>" class="btn btn-sm btn-primary">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-3">
      <a href="/events.php" class="btn btn-outline-primary">View All Events</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Standings -->
<?php if (!empty($standings)): ?>
<section class="mb-5 bg-light py-4">
  <div class="container">
    <h2>Current Standings</h2>
    <table class="table table-striped">
      <thead><tr><th>#</th><th>Team</th><th>Wins</th><th>Losses</th><th>Points</th></tr></thead>
      <tbody>
        <?php $rank = 1; foreach ($standings as $s): ?>
          <tr>
            <td><?=$rank++?></td>
            <td><a href="/team.php?id=<?=urlencode($s['slug'])?>"><?=htmlspecialchars($s['name'])?></a></td>
            <td><?=$s['wins']?></td>
            <td><?=$s['losses']?></td>
            <td><strong><?=$s['points']?></strong></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="text-center mt-3">
      <a href="/standings.php" class="btn btn-outline-primary">View Full Standings</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Latest News -->
<?php if (!empty($news)): ?>
<section class="mb-5">
  <div class="container">
    <h2>Latest News</h2>
    <div class="row">
      <?php foreach ($news as $n): ?>
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card h-100">
            <?php if ($n['image']): ?>
              <img src="<?=htmlspecialchars($n['image'])?>" class="card-img-top" alt="<?=htmlspecialchars($n['title'])?>"> 
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($n['title'])?></h5>
              <p class="card-text"><small class="text-muted"><?=date('M d, Y', strtotime($n['created_at']))?></small></p>
              <p class="card-text"><?=substr(htmlspecialchars($n['content']),0,100)?><?=strlen($n['content']) > 100 ? '...' : ''?></p>
              <a href="/news.php?id=<?=$n['id']?>" class="btn btn-sm btn-primary">Read More</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-3">
      <a href="/news.php" class="btn btn-outline-primary">View All News</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Recent Results -->
<?php if (!empty($results)): ?>
<section class="mb-5 bg-light py-4">
  <div class="container">
    <h2>Recent Results</h2>
    <div class="row">
      <?php foreach ($results as $r): ?>
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title"><?=htmlspecialchars($r['title'])?></h5>
              <p style="font-size:24px; margin:15px 0;">
                <strong><?=htmlspecialchars($r['home_team'])?></strong> <span style="color:var(--brand);">vs</span> <strong><?=htmlspecialchars($r['away_team'])?></strong>
              </p>
              <p style="font-size:20px; color:var(--brand);"><strong><?=$r['home_score']?> - <?=$r['away_score']?></strong></p>
              <small class="text-muted"><?=date('M d, Y', strtotime($r['start_at']))?></small>
              <br><br>
              <a href="/event.php?id=<?=$r['id']?>" class="btn btn-sm btn-primary">Match Report</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
