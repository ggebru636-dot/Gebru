<?php
// standings.php (Full league standings)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Standings';
require_once __DIR__ . '/inc/header.php';

$standings = $pdo->query("SELECT s.id, t.name, t.slug, s.wins, s.losses, s.points FROM standings s JOIN teams t ON s.team_id = t.id ORDER BY s.points DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h1>League Standings</h1>
  
  <?php if (empty($standings)): ?>
    <div class="alert alert-info">No standings data yet.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
          <tr><th>#</th><th>Team</th><th>Wins</th><th>Losses</th><th>Points</th></tr>
        </thead>
        <tbody>
          <?php $rank = 1; foreach ($standings as $s): ?>
            <tr>
              <td><strong><?=$rank++?></strong></td>
              <td><a href="/team.php?id=<?=urlencode($s['slug'])?>"><?=htmlspecialchars($s['name'])?></a></td>
              <td><?=$s['wins']?></td>
              <td><?=$s['losses']?></td>
              <td><strong style="color:var(--brand);"><?=$s['points']?></strong></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
