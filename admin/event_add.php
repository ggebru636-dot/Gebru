<?php
// admin/event_add.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $start_at = trim($_POST['start_at'] ?? '');
    $home_team = trim($_POST['home_team'] ?? '');
    $away_team = trim($_POST['away_team'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if ($title === '') $errors[] = 'Title is required.';
    if ($start_at === '') $errors[] = 'Date/Time is required.';
    
    if (empty($errors)) {
        $pdo->prepare('INSERT INTO events (title, location, start_at, home_team, away_team, description, status) VALUES (?, ?, ?, ?, ?, ?, ?)')
            ->execute([$title, $location, $start_at, $home_team, $away_team, $description, 'scheduled']);
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
    <title>Add Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Add Event</h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
    <?php endif; ?>
    
    <form method="post" class="row g-3">
      <div class="col-12">
        <label class="form-label">Event Title *</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Home Team</label>
        <input type="text" name="home_team" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Away Team</label>
        <input type="text" name="away_team" class="form-control">
      </div>
      <div class="col-12">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control">
      </div>
      <div class="col-12">
        <label class="form-label">Date & Time *</label>
        <input type="datetime-local" name="start_at" class="form-control" required>
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Create Event</button>
        <a href="/admin/events_list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  </body>
</html>
