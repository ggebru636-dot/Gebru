<?php
// inc/header.php
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title ?? 'Tigray Volleyball Federation') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root { --brand: #007bff; }
      body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
      .navbar-brand { font-weight: bold; color: var(--brand) !important; }
      .btn-primary { background-color: var(--brand); border-color: var(--brand); }
      .btn-primary:hover { background-color: #0056b3; }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
      <a class="navbar-brand" href="/">🏐 Tigray Volleyball</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="/events.php">Events</a></li>
          <li class="nav-item"><a class="nav-link" href="/teams.php">Teams</a></li>
          <li class="nav-item"><a class="nav-link" href="/standings.php">Standings</a></li>
          <li class="nav-item"><a class="nav-link" href="/news.php">News</a></li>
          <li class="nav-item"><a class="nav-link" href="/gallery.php">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="/referees.php">Referees</a></li>
          <li class="nav-item"><a class="nav-link" href="/membership.php">Membership</a></li>
          <li class="nav-item"><a class="nav-link" href="/contact.php">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/login.php">Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
