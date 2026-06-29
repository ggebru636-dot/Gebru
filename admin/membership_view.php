<?php
// admin/membership_view.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    header('Location: /admin/memberships_list.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM memberships WHERE id = ?');
$stmt->execute([$id]);
$membership = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$membership) {
    header('Location: /admin/memberships_list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'pending';
    $payment_status = $_POST['payment_status'] ?? 'unpaid';
    $notes = trim($_POST['notes'] ?? '');
    
    $pdo->prepare('UPDATE memberships SET status = ?, payment_status = ?, notes = ? WHERE id = ?')
        ->execute([$status, $payment_status, $notes, $id]);
    
    // Try to send email
    $subject = 'Membership Application Update - Tigray Volleyball Federation';
    $body = "Dear {$membership['name']},\n\n";
    $body .= "Your membership application status has been updated to: " . strtoupper($status) . "\n";
    $body .= "Payment Status: " . strtoupper($payment_status) . "\n\n";
    if ($notes) $body .= "Notes: $notes\n\n";
    $body .= "Best regards,\nTigray Volleyball Federation";
    
    @mail($membership['email'], $subject, $body);
    
    header('Location: /admin/memberships_list.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Membership Application</h1>
    
    <div class="row">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Applicant Information</h5>
            <p><strong>Name:</strong> <?=htmlspecialchars($membership['name'])?></p>
            <p><strong>Email:</strong> <a href="mailto:<?=htmlspecialchars($membership['email'])?>"><?=htmlspecialchars($membership['email'])?></a></p>
            <p><strong>Phone:</strong> <?=htmlspecialchars($membership['phone'] ?? 'N/A')?></p>
            <p><strong>Membership Type:</strong> <?=htmlspecialchars(ucfirst($membership['membership_type']))?></p>
            <p><strong>Applied:</strong> <?=date('M d, Y H:i', strtotime($membership['created_at']))?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Status</h5>
            <p><span class="badge <?= $membership['status'] === 'approved' ? 'bg-success' : 'bg-warning' ?>"><?=ucfirst($membership['status'])?></span></p>
            <p><span class="badge <?= $membership['payment_status'] === 'paid' ? 'bg-success' : 'bg-secondary' ?>"><?=ucfirst($membership['payment_status'])?></span></p>
          </div>
        </div>
      </div>
    </div>

    <form method="post" class="row g-3 mt-3">
      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="pending" <?= $membership['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="approved" <?= $membership['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
          <option value="rejected" <?= $membership['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Payment Status</label>
        <select name="payment_status" class="form-select">
          <option value="unpaid" <?= $membership['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
          <option value="paid" <?= $membership['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="4"><?=htmlspecialchars($membership['notes'] ?? '')?></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Update & Notify</button>
        <a href="/admin/memberships_list.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  </div>
  </body>
</html>
