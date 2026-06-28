<?php
// admin/index.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/admin/">Admin</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/admin/news_list.php">News</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/events_list.php">Events</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <h1>Dashboard</h1>
    <p>Welcome, <?=htmlspecialchars($_SESSION['admin_user']['username'])?>.</p>

    <div class="row">
      <div class="col-md-6">
        <div class="card mb-3"><div class="card-body">
          <h5 class="card-title">News</h5>
          <p>Add or manage news articles.</p>
          <a href="/admin/news_list.php" class="btn btn-sm btn-primary">Manage News</a>
        </div></div>
      </div>
      <div class="col-md-6">
        <div class="card mb-3"><div class="card-body">
          <h5 class="card-title">Events</h5>
          <p>Manage events and fixtures.</p>
          <a href="/admin/events_list.php" class="btn btn-sm btn-primary">Manage Events</a>
        </div></div>
      </div>
    </div>
  </div>
  </body>
</html>
