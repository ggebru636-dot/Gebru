<?php
// inc/header.php
if (!isset($page_title)) $page_title = 'Tigray Volleyball Federation';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <?php if (file_exists(__DIR__ . '/../assets/images/logo.png')): ?>
          <img src="/assets/images/logo.png" alt="TVF logo" style="height:42px; margin-right:10px;">
        <?php endif; ?>
        <span>Tigray Volleyball Federation</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="/news.php">News</a></li>
          <li class="nav-item"><a class="nav-link" href="/teams.php">Teams</a></li>
          <li class="nav-item"><a class="nav-link" href="/contact.php">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
