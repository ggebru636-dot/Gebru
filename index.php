<?php
// index.php
$page_title = 'Home — Tigray Volleyball Federation';
include 'inc/header.php';
include 'inc/db.php';

// Latest news
$stmt = $pdo->query('SELECT id, title, slug, substr(content,1,250) as excerpt, created_at FROM news ORDER BY created_at DESC LIMIT 3');
$latest = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
  <div class="col-md-8">
    <h1>Welcome to the Tigray Volleyball Federation</h1>
    <p class="lead">Official site for news, events, teams and development of volleyball in Tigray.</p>
    <hr>

    <h2>Latest news</h2>
    <?php if ($latest): foreach($latest as $item): ?>
      <article class="mb-4">
        <h3><a href="/news.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['title']) ?></a></h3>
        <p class="text-muted"><?= htmlspecialchars($item['created_at']) ?></p>
        <p><?= nl2br(htmlspecialchars($item['excerpt'])) ?>...</p>
        <a href="/news.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-primary">Read more</a>
      </article>
    <?php endforeach; else: ?>
      <p>No news yet. Use the admin scripts to add sample content.</p>
    <?php endif; ?>
  </div>

  <div class="col-md-4">
    <h3>Upcoming events</h3>
    <?php
    $stmt = $pdo->query('SELECT id,title,start_at FROM events WHERE start_at >= datetime("now") ORDER BY start_at ASC LIMIT 5');
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($events): ?>
      <ul class="list-unstyled">
      <?php foreach($events as $e): ?>
        <li class="mb-2"><strong><?= htmlspecialchars($e['title']) ?></strong><br><small class="text-muted"><?= htmlspecialchars($e['start_at']) ?></small></li>
      <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No upcoming events.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'inc/footer.php'; ?>
