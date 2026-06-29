<?php
// admin/seed_data.php
// Run this once to populate sample data
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Add sample teams
        $teams = [
            ['Mekelle Volleyball Club', 'mekelle-vc', 'Mekelle\'s top volleyball team'],
            ['Adwa Sports Academy', 'adwa-sports', 'Youth development focused team'],
            ['Tigray United', 'tigray-united', 'National representative team'],
        ];
        foreach ($teams as [$name, $slug, $desc]) {
            try {
                $pdo->prepare('INSERT INTO teams (name, slug, description) VALUES (?, ?, ?)')->execute([$name, $slug, $desc]);
                $id = $pdo->lastInsertId();
                $pdo->prepare('INSERT INTO standings (team_id, wins, losses, points) VALUES (?, ?, ?, ?)')->execute([$id, rand(5, 15), rand(2, 10), rand(20, 50)]);
            } catch (Exception $e) {}
        }

        // Add sample referees
        $referees = [
            ['Abebe Tekle', 'abebe@example.com', '251-9-xx-xx-xx', 'Level 3', '2023-06-15', 'Experienced international referee'],
            ['Almaz Gebre', 'almaz@example.com', '251-9-xx-xx-xx', 'Level 2', '2022-09-20', 'National tournament referee'],
            ['Desta Hailu', 'desta@example.com', '251-9-xx-xx-xx', 'Level 1', '2024-01-10', 'Regional referee'],
        ];
        foreach ($referees as [$name, $email, $phone, $level, $cert_date, $bio]) {
            try {
                $pdo->prepare('INSERT INTO referees (name, email, phone, level, certification_date, bio) VALUES (?, ?, ?, ?, ?, ?)')->execute([$name, $email, $phone, $level, $cert_date, $bio]);
            } catch (Exception $e) {}
        }

        // Add sample courses
        $courses = [
            ['Volleyball Basics', 'Introduction to volleyball fundamentals', 'Coach Amare', 'coaching', '2024-07-01', '2024-07-15', 30],
            ['Advanced Techniques', 'Master advanced volleyball techniques', 'Coach Yohannes', 'coaching', '2024-08-01', '2024-08-20', 20],
            ['Referee Training Level 1', 'Become a certified level 1 referee', 'Abebe Tekle', 'referee', '2024-07-20', '2024-08-05', 25],
        ];
        foreach ($courses as [$title, $desc, $instructor, $type, $start, $end, $capacity]) {
            try {
                $pdo->prepare('INSERT INTO courses (title, description, instructor, course_type, start_date, end_date, capacity) VALUES (?, ?, ?, ?, ?, ?, ?)')->execute([$title, $desc, $instructor, $type, $start, $end, $capacity]);
            } catch (Exception $e) {}
        }

        // Add sample sponsors
        $sponsors = [
            ['Tech Ethiopia', 'https://example.com/logo1.png', 'https://techethiopia.com', 'platinum', 'sponsor@techethiopia.com', '251-1-xxxx-xxxx'],
            ['Gold Finance', 'https://example.com/logo2.png', 'https://goldfinance.et', 'gold', 'info@goldfinance.et', '251-1-xxxx-xxxx'],
            ['Green Energy Solutions', 'https://example.com/logo3.png', 'https://greenenergy.et', 'silver', 'contact@greenenergy.et', '251-1-xxxx-xxxx'],
            ['Local Sports Gear', 'https://example.com/logo4.png', 'https://sportsgear.et', 'bronze', 'info@sportsgear.et', '251-1-xxxx-xxxx'],
        ];
        foreach ($sponsors as [$name, $logo, $website, $tier, $email, $phone]) {
            try {
                $pdo->prepare('INSERT INTO sponsors (name, logo, website, tier, contact_email, phone) VALUES (?, ?, ?, ?, ?, ?)')->execute([$name, $logo, $website, $tier, $email, $phone]);
            } catch (Exception $e) {}
        }

        // Add sample gallery
        $gallery = [
            ['Tournament 2024 - Final Match', 'https://via.placeholder.com/600x400?text=Final+Match', 'Exciting final match of 2024 tournament', 'photo'],
            ['Team Training Session', 'https://via.placeholder.com/600x400?text=Training', 'Regular team training and conditioning', 'photo'],
            ['Youth Development Program', 'https://via.placeholder.com/600x400?text=Youth+Dev', 'Youth players in development program', 'photo'],
            ['Community Volleyball Event', 'https://via.placeholder.com/600x400?text=Community', 'Community engagement and fun matches', 'photo'],
        ];
        foreach ($gallery as [$title, $url, $desc, $type]) {
            try {
                $pdo->prepare('INSERT INTO gallery (title, description, image_url, media_type, uploaded_by) VALUES (?, ?, ?, ?, ?)')->execute([$title, $desc, $url, $type, $_SESSION['admin_user']['id']]);
            } catch (Exception $e) {}
        }

        // Add sample news
        $news = [
            ['2024 Championship Announced', '2024-championship-announced', 'The Tigray Volleyball Federation is proud to announce the 2024 championship tournament...', 'https://via.placeholder.com/600x400?text=Championship'],
            ['New Training Facility Opens', 'new-training-facility', 'We are excited to open our new state-of-the-art training facility...', 'https://via.placeholder.com/600x400?text=Facility'],
            ['Youth Program Expands', 'youth-program-expands', 'Our youth development program is expanding to new regions...', 'https://via.placeholder.com/600x400?text=Youth'],
        ];
        foreach ($news as [$title, $slug, $content, $image]) {
            try {
                $pdo->prepare('INSERT INTO news (title, slug, content, image) VALUES (?, ?, ?, ?)')->execute([$title, $slug, $content, $image]);
            } catch (Exception $e) {}
        }

        $message = '<div class="alert alert-success">Sample data added successfully! (Duplicate entries were skipped.)</div>';
    } catch (Exception $e) {
        $message = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Seed Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Seed Sample Data</h1>
    <p class="text-muted">Add sample teams, referees, courses, sponsors, gallery items, and news for testing.</p>
    
    <?php echo $message; ?>
    
    <form method="post" class="mt-4">
      <p><strong>This will add:</strong></p>
      <ul>
        <li>3 Sample Teams with standings</li>
        <li>3 Sample Referees</li>
        <li>3 Sample Courses</li>
        <li>4 Sample Sponsors (mixed tiers)</li>
        <li>4 Sample Gallery Items</li>
        <li>3 Sample News Articles</li>
      </ul>
      <button class="btn btn-primary btn-lg" onclick="return confirm('Add sample data?');">Add Sample Data</button>
      <a href="/admin/" class="btn btn-secondary btn-lg">Back to Dashboard</a>
    </form>
  </div>
  </body>
</html>
