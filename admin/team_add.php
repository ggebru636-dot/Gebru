<?php
// admin/team_add.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if ($name === '') $errors[] = 'Team name is required.';
    if ($slug === '') $errors[] = 'Slug is required.';
    
    if (empty($errors)) {
        try {
            $pdo->prepare('INSERT INTO teams (name, slug, description) VALUES (:name, :slug, :desc)')
                ->execute([':name'=>$name, ':slug'=>$slug, ':desc'=>$description]);
            $team_id = $pdo->lastInsertId();
            // Create standing entry for the team
            $pdo->prepare('INSERT INTO standings (team_id, wins, losses, points) VALUES (:id, 0, 0, 0)')
                ->execute([':id'=>$team_id]);
            header('Location: /admin/teams_list.php');
            exit;
        } catch (Exception $e) {
            $errors[] = 'Slug must be unique. ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Team</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Add Team</h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
    <?php endif; ?>
    
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Team Name *</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Slug (URL-friendly name) *</label>
        <input type="text" name="slug" class="form-control" required>
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Create Team</button>
        <a href="/admin/teams_list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  </body>
</html>
