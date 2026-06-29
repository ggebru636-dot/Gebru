<?php
// admin/login.php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/auth.php';

if (!empty($_SESSION['admin_user'])) {
    header('Location: /admin/');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if (admin_login($u, $p)) {
        // Check if password change is forced
        $userId = $_SESSION['admin_user']['id'];
        $stmt = $pdo->prepare('SELECT force_password_change FROM users WHERE id = :id');
        $stmt->execute([':id'=>$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['force_password_change']) {
            header('Location: /admin/change_password.php?forced=1');
            exit;
        }
        header('Location: /admin/');
        exit;
    } else {
        $error = 'Invalid credentials.';
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Admin Login</h3>
            <?php if ($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required>
              </div>
              <button class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </body>
</html>
