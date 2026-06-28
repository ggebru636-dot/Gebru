<?php
// admin/news_edit.php - create/edit news with optional image upload
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$editing = false;
$post = ['title'=>'','content'=>'','image'=>''];
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = :id');
    $stmt->execute([':id'=>$_GET['id']]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($post) $editing = true;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title === '' || $content === '') {
        $errors[] = 'Title and content are required.';
    }
    // handle upload
    $uploaded_path = '';
    if (!empty($_FILES['image']['name'])) {
        $f = $_FILES['image'];
        $allowed = ['image/jpeg','image/png','image/webp'];
        if ($f['error'] === UPLOAD_ERR_OK && in_array($f['type'],$allowed) && $f['size'] <= 2*1024*1024) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $name = 'uploads/' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            if (!is_dir(__DIR__ . '/../uploads')) mkdir(__DIR__ . '/../uploads', 0755, true);
            if (move_uploaded_file($f['tmp_name'], __DIR__ . '/../' . $name)) {
                $uploaded_path = $name;
            } else {
                $errors[] = 'Failed to move uploaded file.';
            }
        } else {
            $errors[] = 'Invalid image (allowed jpg/png/webp, max 2MB).';
        }
    }

    if (empty($errors)) {
        $slug = preg_replace('/[^a-z0-9]+/i','-',strtolower($title));
        // ensure unique slug
        $base = $slug; $i = 1;
        while (true) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM news WHERE slug = :s' . ($editing ? ' AND id != :id' : ''));
            $params = [':s'=>$slug]; if ($editing) $params[':id']=$post['id'];
            $stmt->execute($params);
            if ($stmt->fetchColumn() == 0) break;
            $slug = $base . '-' . $i; $i++;
        }
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE news SET title=:t,slug=:s,content=:c' . ($uploaded_path? ',image=:img':'' ) . ' WHERE id = :id');
            $params = [':t'=>$title,':s'=>$slug,':c'=>$content,':id'=>$post['id']];
            if ($uploaded_path) $params[':img']=$uploaded_path;
            $stmt->execute($params);
        } else {
            $stmt = $pdo->prepare('INSERT INTO news (title,slug,content,image) VALUES (:t,:s,:c,:img)');
            $stmt->execute([':t'=>$title,':s'=>$slug,':c'=>$content,':img'=>$uploaded_path]);
        }
        header('Location: /admin/news_list.php');
        exit;
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $editing ? 'Edit' : 'New' ?> News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1><?= $editing ? 'Edit' : 'New' ?> Article</h1>
    <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="<?=htmlspecialchars($post['title']??'')?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="8" required><?=htmlspecialchars($post['content']??'')?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Image (optional)</label>
        <input type="file" name="image" class="form-control">
        <?php if (!empty($post['image'])): ?>
          <div class="mt-2"><img src="/<?=htmlspecialchars($post['image'])?>" alt="" style="max-width:200px"></div>
        <?php endif; ?>
      </div>
      <button class="btn btn-primary"><?= $editing ? 'Save' : 'Publish' ?></button>
      <a href="/admin/news_list.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
  </body>
</html>
