<?php
// admin/change_password.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$userId = $_SESSION['admin_user']['id'];
$forced = isset($_GET['forced']) && $_GET['forced'] == 1;
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    if ($new === '') $errors[] = 'New password cannot be empty.';
    if ($new !== $confirm) $errors[] = 'New password and confirmation do not match.';

    if (empty($errors)) {
        // verify current
        $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = :id');
        $stmt->execute([':id'=>$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row || !password_verify($current, $row['password_hash'])) {
            $errors[] = 'Current password is incorrect.';
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $pdo->prepare('UPDATE users SET password_hash = :h, force_password_change = 0 WHERE id = :id')
                ->execute([':h'=>$hash,':id'=>$userId]);
            $success = 'Password changed successfully.';
            if ($forced) {
                $success .= ' You will be redirected to the dashboard in 3 seconds...';
                echo '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Password Changed</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body><div class="container my-5"><div class="alert alert-success">'. htmlspecialchars($success) .'</div></div><script>setTimeout(function(){window.location.href="/admin/";},3000);</script></body></html>';
                exit;
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1><?= $forced ? 'Set Your Password' : 'Change Password' ?></h1>
    <?php if ($forced): ?><p class="text-muted">You must set a new password before continuing.</p><?php endif; ?>
    <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Current password</label>
        <input type="password" name="current_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">New password</label>
        <input type="password" name="new_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm new password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button class="btn btn-primary">Change password</button>
      <?php if (!$forced): ?><a href="/admin/" class="btn btn-secondary">Back</a><?php endif; ?>
    </form>
  </div>
  </body>
</html>
