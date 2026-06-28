<?php
// news.php - list and single view
$page_title = 'News — Tigray Volleyball Federation';
include 'inc/header.php';
include 'inc/db.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
  $stmt = $pdo->prepare('SELECT * FROM news WHERE id = :id');
  $stmt->execute([':id'=>$_GET['id']]);
  $post = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$post) {
    echo '<p>Article not found.</p>';
  } else {
    echo "<h1>" . htmlspecialchars($post['title']) . "</h1>";
    echo "<p class='text-muted'>" . htmlspecialchars($post['created_at']) . "</p>";
    if (!empty($post['image'])) {
      echo '<div class="mb-3"><img src="/' . htmlspecialchars($post['image']) . '" alt="" style="max-width:100%"></div>';
    }
    echo "<div>" . nl2br(htmlspecialchars($post['content'])) . "</div>";
  }
} else {
  $stmt = $pdo->query('SELECT id,title,created_at FROM news ORDER BY created_at DESC');
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo '<h1>News</h1>';
  foreach($posts as $p) {
    echo '<article class="mb-3">';
    echo '<h3><a href="/news.php?id=' . $p['id'] . '">' . htmlspecialchars($p['title']) . '</a></h3>';
    echo '<p class="text-muted">' . htmlspecialchars($p['created_at']) . '</p>';
    echo '</article>';
  }
}

include 'inc/footer.php';
