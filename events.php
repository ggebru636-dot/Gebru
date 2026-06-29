<?php
// events.php (Events/Fixtures list & calendar)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Events & Fixtures';
require_once __DIR__ . '/inc/header.php';

$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['all','scheduled','completed']) ? $_GET['filter'] : 'scheduled';

if ($filter === 'all') {
    $query = 'SELECT id,title,home_team,away_team,start_at,location,status,home_score,away_score FROM events ORDER BY start_at DESC';
} elseif ($filter === 'scheduled') {
    $query = "SELECT id,title,home_team,away_team,start_at,location,status FROM events WHERE status='scheduled' AND start_at > datetime('now') ORDER BY start_at ASC";
} else {
    $query = "SELECT id,title,home_team,away_team,start_at,location,status,home_score,away_score FROM events WHERE status='completed' ORDER BY start_at DESC";
}

$events = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h1>Events & Fixtures</h1>
  
  <!-- Filter tabs -->
  <ul class="nav nav-tabs mb-4">
    <li class="nav-item"><a class="nav-link <?= $filter === 'scheduled' ? 'active' : '' ?>" href="?filter=scheduled">Upcoming</a></li>
    <li class="nav-item"><a class="nav-link <?= $filter === 'completed' ? 'active' : '' ?>" href="?filter=completed">Results</a></li>
    <li class="nav-item"><a class="nav-link <?= $filter === 'all' ? 'active' : '' ?>" href="?filter=all">All Events</a></li>
  </ul>

  <?php if (empty($events)): ?>
    <div class="alert alert-info">No events found.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($events as $e): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="badge <?= $e['status'] === 'completed' ? 'bg-success' : 'bg-warning' ?> mb-2">{{ $e['status'] === 'completed' ? 'Final' : 'Upcoming' }}</div>
              <h5 class="card-title"><?=htmlspecialchars($e['title'])?></h5>
              <p class="card-text">
                <strong><?=htmlspecialchars($e['home_team'] ?? 'TBD')?></strong> vs <strong><?=htmlspecialchars($e['away_team'] ?? 'TBD')?></strong>
              </p>
              <?php if (isset($e['home_score']) && isset($e['away_score'])): ?>
                <p style="font-size:18px; color:var(--brand);"><strong><?=$e['home_score']?> - <?=$e['away_score']?></strong></p>
              <?php endif; ?>
              <p class="card-text"><small class="text-muted">📅 <?=date('M d, Y H:i', strtotime($e['start_at']))?></small></p>
              <p class="card-text"><small class="text-muted">📍 <?=htmlspecialchars($e['location'] ?? 'Location TBD')?></small></p>
              <a href="/event.php?id=<?=$e['id']?>" class="btn btn-sm btn-primary">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
of
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
