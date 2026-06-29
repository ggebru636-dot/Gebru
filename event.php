<?php
// event.php (Individual event details)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Event Details';
require_once __DIR__ . '/inc/header.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    header('Location: /events.php');
    exit;
}

$event = $pdo->prepare('SELECT * FROM events WHERE id = :id')->execute([':id'=>$id]);
$event = $pdo->prepare('SELECT * FROM events WHERE id = :id')->fetchOne();
$stmt = $pdo->prepare('SELECT * FROM events WHERE id = :id');
$stmt->execute([':id'=>$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo '<div class="container my-5"><div class="alert alert-danger">Event not found.</div></div>';
    require_once __DIR__ . '/inc/footer.php';
    exit;
}
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-8">
      <h1><?=htmlspecialchars($event['title'])?></h1>
      <div class="mb-4">
        <span class="badge <?= $event['status'] === 'completed' ? 'bg-success' : 'bg-warning' ?>"><?= ucfirst($event['status']) ?></span>
      </div>

      <!-- Match Card -->
      <div class="card mb-4">
        <div class="card-body text-center p-5">
          <h3><?=htmlspecialchars($event['home_team'] ?? 'TBD')?></h3>
          <?php if (isset($event['home_score']) && isset($event['away_score'])): ?>
            <p style="font-size:48px; color:var(--brand); margin:20px 0;"><strong><?=$event['home_score']?> - <?=$event['away_score']?></strong></p>
          <?php endif; ?>
          <h3><?=htmlspecialchars($event['away_team'] ?? 'TBD')?></h3>
        </div>
      </div>

      <!-- Event Details -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Details</h5>
          <p><strong>📅 Date & Time:</strong> <?=date('F d, Y H:i', strtotime($event['start_at']))?></p>
          <p><strong>📍 Location:</strong> <?=htmlspecialchars($event['location'] ?? 'Location TBD')?></p>
          <p><strong>📝 Description:</strong></p>
          <p><?=nl2br(htmlspecialchars($event['description'] ?? 'No description provided'))?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Event Info</h5>
          <p><strong>Type:</strong> <?=htmlspecialchars(ucfirst($event['event_type'] ?? 'match'))?></p>
          <p><strong>Status:</strong> <?=htmlspecialchars(ucfirst($event['status'] ?? 'scheduled'))?></p>
          <p><small class="text-muted">Created: <?=date('M d, Y', strtotime($event['created_at']))?></small></p>
        </div>
      </div>
    </div>
  </div>

  <a href="/events.php" class="btn btn-outline-primary">← Back to Events</a>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
