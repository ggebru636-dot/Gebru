<?php
// admin/index.php (Admin Dashboard)
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

// Get stats
$contacts_count = $pdo->query('SELECT COUNT(*) FROM contacts WHERE archived = 0')->fetchColumn();
$teams_count = $pdo->query('SELECT COUNT(*) FROM teams')->fetchColumn();
$events_count = $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn();
$news_count = $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
$memberships_count = $pdo->query('SELECT COUNT(*) FROM memberships')->fetchColumn();
$gallery_count = $pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn();
$newsletter_count = $pdo->query('SELECT COUNT(*) FROM newsletter_subscribers WHERE unsubscribed_at IS NULL')->fetchColumn();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root { --brand: #007bff; }
      .stat-card { text-align: center; padding: 20px; border-radius: 8px; background: #f8f9fa; }
      .stat-card h3 { color: var(--brand); margin: 10px 0; }
    </style>
  </head>
  <body>
  <div class="container my-5">
    <h1>Admin Dashboard</h1>
    <p class="text-muted">Welcome back!</p>

    <!-- Statistics -->
    <div class="row mb-5">
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>📧</div>
          <h3><?=$contacts_count?></h3>
          <p>Contact Messages</p>
          <a href="/admin/contacts.php" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>⚽</div>
          <h3><?=$teams_count?></h3>
          <p>Teams</p>
          <a href="/admin/teams_list.php" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>📅</div>
          <h3><?=$events_count?></h3>
          <p>Events</p>
          <a href="/admin/events_list.php" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>📰</div>
          <h3><?=$news_count?></h3>
          <p>News Articles</p>
          <a href="/admin/news_list.php" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>👥</div>
          <h3><?=$memberships_count?></h3>
          <p>Memberships</p>
          <a href="/admin/memberships_list.php" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>🖼️</div>
          <h3><?=$gallery_count?></h3>
          <p>Gallery Items</p>
          <a href="/admin/gallery_list.php" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>📬</div>
          <h3><?=$newsletter_count?></h3>
          <p>Newsletter Subscribers</p>
          <a href="/admin/newsletter_list.php" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <div>🎓</div>
          <h3>Admin</h3>
          <p>Tools</p>
          <a href="/admin/seed_data.php" class="btn btn-sm btn-outline-primary">Seed Data</a>
        </div>
      </div>
    </div>

    <!-- Quick Links -->
    <h3>Quick Links</h3>
    <div class="list-group">
      <a href="/admin/news_list.php" class="list-group-item list-group-item-action">📰 Manage News & Announcements</a>
      <a href="/admin/contacts.php" class="list-group-item list-group-item-action">📧 View Contact Messages</a>
      <a href="/admin/events_list.php" class="list-group-item list-group-item-action">📅 Manage Events & Fixtures</a>
      <a href="/admin/teams_list.php" class="list-group-item list-group-item-action">⚽ Manage Teams</a>
      <a href="/admin/gallery_list.php" class="list-group-item list-group-item-action">🖼️ Manage Gallery</a>
      <a href="/admin/memberships_list.php" class="list-group-item list-group-item-action">👥 View Memberships</a>
      <a href="/admin/newsletter_list.php" class="list-group-item list-group-item-action">📬 View Newsletter Subscribers</a>
      <a href="/admin/change_password.php" class="list-group-item list-group-item-action">🔐 Change Password</a>
      <a href="/admin/logout.php" class="list-group-item list-group-item-action">🚪 Logout</a>
    </div>
  </div>
  </body>
</html>
