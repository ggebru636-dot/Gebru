<?php
// referees.php (Referees & Coaching page)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Referees & Coaching';
require_once __DIR__ . '/inc/header.php';

$referees = $pdo->query('SELECT id,name,email,level,certification_date,bio,photo FROM referees ORDER BY name ASC')->fetchAll(PDO::FETCH_ASSOC);
$courses = $pdo->query('SELECT id,title,description,instructor,course_type,start_date,end_date,capacity FROM courses WHERE start_date > datetime("now") ORDER BY start_date ASC LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h1>Referees & Coaching</h1>
  
  <!-- Referees Section -->
  <h2 class="mt-5">Our Referees</h2>
  <?php if (empty($referees)): ?>
    <p class="text-muted">No referees listed yet.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($referees as $ref): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card">
            <?php if ($ref['photo']): ?>
              <img src="<?=htmlspecialchars($ref['photo'])?>" class="card-img-top" alt="<?=htmlspecialchars($ref['name'])?>">
            <?php else: ?>
              <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
                <span style="color:#999;">Referee Photo</span>
              </div>
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($ref['name'])?></h5>
              <p class="card-text">
                <strong>Level:</strong> <?=htmlspecialchars(ucfirst($ref['level'] ?? 'N/A'))?><br>
                <?php if ($ref['certification_date']): ?>
                  <small class="text-muted">Certified: <?=date('M Y', strtotime($ref['certification_date']))?></small>
                <?php endif; ?>
              </p>
              <?php if ($ref['bio']): ?>
                <p class="card-text"><small><?=htmlspecialchars(substr($ref['bio'], 0, 80))?><?= strlen($ref['bio']) > 80 ? '...' : '' ?></small></p>
              <?php endif; ?>
              <?php if ($ref['email']): ?>
                <a href="mailto:<?=htmlspecialchars($ref['email'])?>" class="btn btn-sm btn-outline-primary">Contact</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Coaching Courses -->
  <h2 class="mt-5">Upcoming Courses</h2>
  <?php if (empty($courses)): ?>
    <p class="text-muted">No upcoming courses at this time.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($courses as $c): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($c['title'])?></h5>
              <p class="card-text">
                <strong>Type:</strong> <?=htmlspecialchars(ucfirst($c['course_type'] ?? 'Course'))?><br>
                <strong>Instructor:</strong> <?=htmlspecialchars($c['instructor'] ?? 'TBD')?><br>
                <strong>Dates:</strong> <?=date('M d', strtotime($c['start_date']))?> - <?=date('M d, Y', strtotime($c['end_date']))?><br>
                <strong>Capacity:</strong> <?=$c['capacity'] ?? 'Unlimited'?>
              </p>
              <?php if ($c['description']): ?>
                <p class="card-text"><small><?=htmlspecialchars(substr($c['description'], 0, 60))?><?= strlen($c['description']) > 60 ? '...' : '' ?></small></p>
              <?php endif; ?>
              <a href="/membership.php" class="btn btn-sm btn-primary">Register</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
