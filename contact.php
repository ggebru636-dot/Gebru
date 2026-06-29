<?php
// contact.php (Contact form)
require_once __DIR__ . '/inc/db.php';
$page_title = 'Contact Us';
require_once __DIR__ . '/inc/header.php';

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($message === '') $errors[] = 'Message is required.';
    
    if (empty($errors)) {
        try {
            $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)')
                ->execute([$name, $email, $message]);
            $success = 'Thank you! Your message has been sent. We will get back to you soon.';
            // Try to send email if configured
            $admin_email = 'admin@example.com'; // Configure this
            @mail($admin_email, 'New Contact Form Submission', "Name: $name\nEmail: $email\nMessage: $message");
        } catch (Exception $e) {
            $errors[] = 'An error occurred. Please try again.';
        }
    }
}
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-8">
      <h1>Contact Us</h1>
      <p>Have questions or want to get in touch? Fill out the form below and we'll respond within 48 hours.</p>
      
      <?php if ($success): ?>
        <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
      <?php endif; ?>
      
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?php foreach ($errors as $e) echo '<div>' . htmlspecialchars($e) . '</div>'; ?></div>
      <?php endif; ?>

      <form method="post" class="row g-3">
        <div class="col-12">
          <label class="form-label">Name *</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Message *</label>
          <textarea name="message" class="form-control" rows="6" required></textarea>
        </div>
        <div class="col-12">
          <button class="btn btn-primary btn-lg">Send Message</button>
        </div>
      </form>
    </div>
    <div class="col-md-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Quick Info</h5>
          <p><strong>📧 Email:</strong><br><a href="mailto:info@tigrayvolleyball.com">info@tigrayvolleyball.com</a></p>
          <p><strong>📞 Phone:</strong><br><a href="tel:+251-1-xxxx-xxxx">+251-1-XXXX-XXXX</a></p>
          <p><strong>📍 Address:</strong><br>Mekelle Volleyball Center<br>Mekelle, Tigray<br>Ethiopia</p>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Follow Us</h5>
          <p>
            <a href="#" class="btn btn-sm btn-outline-primary me-1">Facebook</a>
            <a href="#" class="btn btn-sm btn-outline-primary me-1">Twitter</a>
            <a href="#" class="btn btn-sm btn-outline-primary">Instagram</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
