<?php
// admin/gallery_add.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $media_type = $_POST['media_type'] ?? 'photo';
    
    if ($title === '') $errors[] = 'Title is required.';
    if ($image_url === '') $errors[] = 'Image URL is required.';
    
    if (empty($errors)) {
        $pdo->prepare('INSERT INTO gallery (title, description, image_url, media_type, uploaded_by) VALUES (?, ?, ?, ?, ?)')
            ->execute([$title, $description, $image_url, $media_type, $_SESSION['admin_user']['id']]);
        header('Location: /admin/gallery_list.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Gallery Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Add Gallery Item</h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
    <?php endif; ?>
    
    <form method="post" class="row g-3">
      <div class="col-12">
        <label class="form-label">Title *</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="col-12">
        <label class="form-label">Image URL *</label>
        <input type="url" name="image_url" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Media Type</label>
        <select name="media_type" class="form-select">
          <option value="photo">Photo</option>
          <option value="video">Video</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Add Item</button>
        <a href="/admin/gallery_list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  </body>
</html>
