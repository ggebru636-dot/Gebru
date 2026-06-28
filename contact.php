<?php
// contact.php - simple contact form
$page_title = 'Contact — Tigray Volleyball Federation';
include 'inc/header.php';
?>

<h1>Contact</h1>
<p>Please use this form to get in touch.</p>

<?php if (isset($_GET['status']) && $_GET['status'] === 'thanks'): ?>
  <div class="alert alert-success">Thanks — your message was received.</div>
<?php endif; ?>

<form action="/contact_submit.php" method="post" class="row g-3">
  <div class="col-md-6">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="col-md-6">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="col-12">
    <label for="message" class="form-label">Message</label>
    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Send</button>
  </div>
</form>

<?php include 'inc/footer.php'; ?>
