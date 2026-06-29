<?php
// membership.php (Membership/Registration form)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Membership & Registration';
require_once __DIR__ . '/inc/header.php';

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $membership_type = $_POST['membership_type'] ?? 'player';
    
    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    
    if (empty($errors)) {
        try {
            $pdo->prepare('INSERT INTO memberships (name, email, phone, membership_type, status) VALUES (?, ?, ?, ?, ?)')
                ->execute([$name, $email, $phone, $membership_type, 'pending']);
            $success = 'Thank you! Your membership request has been submitted. We will contact you soon.';
        } catch (Exception $e) {
            $errors[] = 'An error occurred. Please try again.';
        }
    }
}
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-8">
      <h1>Membership & Registration</h1>
      <p>Join the Tigray Volleyball Federation and become part of our growing community.</p>
      
      <?php if ($success): ?>
        <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
      <?php endif; ?>
      
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
      <?php endif; ?>

      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Full Name *</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input type="tel" name="phone" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Membership Type *</label>
          <select name="membership_type" class="form-select" required>
            <option value="player">Player</option>
            <option value="coach">Coach</option>
            <option value="referee">Referee</option>
            <option value="supporter">Supporter</option>
          </select>
        </div>
        <div class="col-12">
          <button class="btn btn-primary">Submit Registration</button>
        </div>
      </form>

      <div class="mt-5">
        <h3>Membership Benefits</h3>
        <ul>
          <li>Access to federation events and tournaments</li>
          <li>Coaching and training programs</li>
          <li>Insurance coverage</li>
          <li>Member discounts on equipment</li>
          <li>Networking opportunities</li>
        </ul>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Membership Tiers</h5>
          <p><strong>Player</strong><br>Full access to tournaments and training.</p>
          <p><strong>Coach</strong><br>Coach certification and team management tools.</p>
          <p><strong>Referee</strong><br>Referee development program and match assignments.</p>
          <p><strong>Supporter</strong><br>Community member support and updates.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
