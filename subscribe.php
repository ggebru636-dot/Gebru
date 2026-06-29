<?php
// subscribe.php (Newsletter subscription handler)
require_once __DIR__ . '/inc/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email address']);
        exit;
    }
    
    try {
        $pdo->prepare('INSERT OR IGNORE INTO newsletter_subscribers (email, subscribed_at) VALUES (?, datetime("now"))')
            ->execute([$email]);
        echo json_encode(['success' => true, 'message' => 'Successfully subscribed!']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Subscription failed. Please try again.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
exit;
