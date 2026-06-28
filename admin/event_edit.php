<?php
// admin/event_edit.php - create/edit events
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$editing = false;
$item = ['title'=>'','location'=>'','start_at'=>'','end_at'=>'','description'=>''];
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM events WHERE id = :id');
    $stmt->execute([':id'=>$_GET['id']]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) $editing = true;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $start = trim($_POST['start_at'] ?? '');
    $end = trim($_POST['end_at'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    if ($title === '') $errors[] = 'Title is required.';
    if (empty($errors)) {
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE events SET title=:t,location=:l,start_at=:s,end_at=:e,description=:d WHERE id = :id');
            $stmt->execute([':t'=>$title,':l'=>$location,':s'=>$start,':e'=>$end,':d'=>$desc,':id'=>$item['id']]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO events (title,location,start_at,end_at,description) VALUES (:t,:l,:s,:e,:d)');
            $stmt->execute([':t'=>$title,':l'=>$location,':s'=>$start,':e'=>$end,':d'=>$desc]);
        }
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
    <title><?= $editing ? 'Edit' : 'New' ?> Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1><?= $editing ? 'Edit' : 'New' ?> Event</h1>
    <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="<?=htmlspecialchars($item['title']??'')?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Location</label>
        <input name="location" class="form-control" value="<?=htmlspecialchars($item['location']??'')?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Start (YYYY-MM-DD HH:MM:SS)</label>
        <input name="start_at" class="form-control" value="<?=htmlspecialchars($item['start_at']??'')?>">
      </div>
      <div class="mb-3">
        <label class="form-label">End (optional)</label>
        <input name="end_at" class="form-control" value="<?=htmlspecialchars($item['end_at']??'')?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="6"><?=htmlspecialchars($item['description']??'')?></textarea>
      </div>
      <button class="btn btn-primary"><?= $editing ? 'Save' : 'Create' ?></button>
      <a href="/admin/events_list.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
  </body>
</html>
