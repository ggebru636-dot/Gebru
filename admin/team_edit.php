<?php
// admin/team_edit.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    header('Location: /admin/teams_list.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM teams WHERE id = ?');
$stmt->execute([$id]);
$team = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$team) {
    header('Location: /admin/teams_list.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if ($name === '') $errors[] = 'Team name is required.';
    if ($slug === '') $errors[] = 'Slug is required.';
    
    if (empty($errors)) {
        try {
            $pdo->prepare('UPDATE teams SET name = ?, slug = ?, description = ? WHERE id = ?')
                ->execute([$name, $slug, $description, $id]);
            header('Location: /admin/teams_list.php');
            exit;
        } catch (Exception $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Team</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Edit Team</h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
    <?php endif; ?>
    
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Team Name *</label>
        <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($team['name'])?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Slug *</label>
        <input type="text" name="slug" class="form-control" value="<?=htmlspecialchars($team['slug'])?>" required>
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"><?=htmlspecialchars($team['description'] ?? '')?></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Update Team</button>
        <a href="/admin/teams_list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  </body>
</html>
