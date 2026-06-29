<?php
// admin/event_edit.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    header('Location: /admin/events_list.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    header('Location: /admin/events_list.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $start_at = trim($_POST['start_at'] ?? '');
    $home_team = trim($_POST['home_team'] ?? '');
    $away_team = trim($_POST['away_team'] ?? '');
    $home_score = isset($_POST['home_score']) && ctype_digit($_POST['home_score']) ? (int)$_POST['home_score'] : null;
    $away_score = isset($_POST['away_score']) && ctype_digit($_POST['away_score']) ? (int)$_POST['away_score'] : null;
    $status = $_POST['status'] ?? 'scheduled';
    $description = trim($_POST['description'] ?? '');
    
    if ($title === '') $errors[] = 'Title is required.';
    if ($start_at === '') $errors[] = 'Date/Time is required.';
    
    if (empty($errors)) {
        $pdo->prepare('UPDATE events SET title = ?, location = ?, start_at = ?, home_team = ?, away_team = ?, home_score = ?, away_score = ?, status = ?, description = ? WHERE id = ?')
            ->execute([$title, $location, $start_at, $home_team, $away_team, $home_score, $away_score, $status, $description, $id]);
        header('Location: /admin/events_list.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Edit Event</h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
    <?php endif; ?>
    
    <form method="post" class="row g-3">
      <div class="col-12">
        <label class="form-label">Event Title *</label>
        <input type="text" name="title" class="form-control" value="<?=htmlspecialchars($event['title'])?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Home Team</label>
        <input type="text" name="home_team" class="form-control" value="<?=htmlspecialchars($event['home_team'] ?? '')?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Away Team</label>
        <input type="text" name="away_team" class="form-control" value="<?=htmlspecialchars($event['away_team'] ?? '')?>">
      </div>
      <div class="col-12">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?=htmlspecialchars($event['location'] ?? '')?>">
      </div>
      <div class="col-12">
        <label class="form-label">Date & Time *</label>
        <input type="datetime-local" name="start_at" class="form-control" value="<?=htmlspecialchars(str_replace(' ', 'T', $event['start_at']))?>" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="scheduled" <?= $event['status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
          <option value="completed" <?= $event['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Home Score</label>
        <input type="number" name="home_score" class="form-control" value="<?=htmlspecialchars($event['home_score'] ?? '')?>" min="0">
      </div>
      <div class="col-md-4">
        <label class="form-label">Away Score</label>
        <input type="number" name="away_score" class="form-control" value="<?=htmlspecialchars($event['away_score'] ?? '')?>" min="0">
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"><?=htmlspecialchars($event['description'] ?? '')?></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Update Event</button>
        <a href="/admin/events_list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  </body>
</html>
