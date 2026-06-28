<?php
// contact_submit.php - store contact submissions in the SQLite DB and redirect back
include 'inc/db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    header('Location: /contact.php?status=error');
    exit;
}

$stmt = $pdo->prepare('INSERT INTO contacts (name,email,message) VALUES (:name,:email,:message)');
$stmt->execute([':name'=>$name, ':email'=>$email, ':message'=>$message]);

header('Location: /contact.php?status=thanks');
exit;
