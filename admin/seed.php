<?php
// admin/seed.php
// Run this script once (via browser or CLI) to create an initial admin user and sample data.
require_once __DIR__ . '/../inc/db.php';

$do_create = true;
// create admin if not exists
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users');
$stmt->execute();
$c = $stmt->fetchColumn();
if ($c > 0) {
    echo "Users already exist. Aborting.\n";
    $do_create = false;
}

if ($do_create) {
    $username = 'admin';
    $password = 'ChangeMe123!';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $pdo->prepare('INSERT INTO users (username,password_hash,email) VALUES (:u,:p,:e)')
        ->execute([':u'=>$username,':p'=>$hash,':e'=>'admin@example.com']);
    echo "Created admin user: $username (password: $password)\n";

    // sample news
    $pdo->prepare('INSERT INTO news (title,slug,content) VALUES (:t,:s,:c)')
        ->execute([':t'=>'Welcome to TVF',':s'=>'welcome-to-tvf',':c'=>'This is the official website of the Tigray Volleyball Federation.']);

    // sample event
    $pdo->prepare('INSERT INTO events (title,location,start_at,description) VALUES (:t,:l,:s,:d)')
        ->execute([':t'=>'Tigray Open Tournament',':l'=>'Mekelle Stadium',':s'=>date('Y-m-d H:i:s', strtotime('+7 days')),':d'=>'Annual open tournament.']);

    echo "Sample news and event created.\n";
}

echo "Done. Please change the admin password after first login.\n";
