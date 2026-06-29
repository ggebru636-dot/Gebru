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
      
      /* Hero Header Styles */
      .hero-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
      }
      .hero-header h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      }
      .hero-header p {
        font-size: 1.25rem;
        margin-bottom: 0;
        opacity: 0.95;
      }
      .hero-header .breadcrumb {
        background: rgba(255,255,255,0.2);
        padding: 10px 15px;
        border-radius: 5px;
        margin-top: 20px;
        display: inline-block;
      }
      .hero-header .breadcrumb-item {
        color: rgba(255,255,255,0.8);
      }
      .hero-header .breadcrumb-item.active {
        color: white;
      }
      .hero-header .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
      }
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
  
  <?php
  // Helper function to display hero header
  function display_hero($title, $subtitle = '', $breadcrumbs = []) {
    echo '<div class="hero-header">';
    echo '<div class="container">';
    echo '<h1>' . htmlspecialchars($title) . '</h1>';
    if ($subtitle) {
      echo '<p>' . htmlspecialchars($subtitle) . '</p>';
    }
    if (!empty($breadcrumbs)) {
      echo '<nav aria-label="breadcrumb">';
      echo '<ol class="breadcrumb justify-content-center">';
      echo '<li class="breadcrumb-item"><a href="/" style="color: rgba(255,255,255,0.8);">Home</a></li>';
      foreach ($breadcrumbs as $crumb => $link) {
        if ($link) {
          echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($link) . '" style="color: rgba(255,255,255,0.8);">' . htmlspecialchars($crumb) . '</a></li>';
        } else {
          echo '<li class="breadcrumb-item active">' . htmlspecialchars($crumb) . '</li>';
        }
      }
      echo '</ol>';
      echo '</nav>';
    }
    echo '</div>';
    echo '</div>';
  }
  ?>
  
  <main>
