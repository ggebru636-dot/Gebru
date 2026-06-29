<?php
// admin/news_add.php (Add news)
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image = trim($_POST['image'] ?? '');
    
    if ($title === '') $errors[] = 'Title is required.';
    if ($slug === '') $errors[] = 'Slug is required.';
    if ($content === '') $errors[] = 'Content is required.';
    
    if (empty($errors)) {
        try {
            $pdo->prepare('INSERT INTO news (title, slug, content, image) VALUES (?, ?, ?, ?)')
                ->execute([$title, $slug, $content, $image ?: null]);
            header('Location: /admin/news_list.php');
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
    <title>Add News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Add News Article</h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
    <?php endif; ?>
    
    <form method="post" class="row g-3">
      <div class="col-12">
        <label class="form-label">Title *</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="col-12">
        <label class="form-label">Slug (URL-friendly title) *</label>
        <input type="text" name="slug" class="form-control" required>
      </div>
      <div class="col-12">
        <label class="form-label">Content *</label>
        <textarea name="content" class="form-control" rows="6" required></textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Image URL</label>
        <input type="url" name="image" class="form-control" placeholder="https://example.com/image.jpg">
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Create Article</button>
        <a href="/admin/news_list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
  </body>
</html>
