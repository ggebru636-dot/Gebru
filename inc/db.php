<?php
// inc/db.php
// Creates a PDO connection to a SQLite database and initializes schema on first run.
$db_file = __DIR__ . '/../data/database.sqlite';
$need_init = !file_exists($db_file);
try {
    if (!is_dir(dirname($db_file))) {
        mkdir(dirname($db_file), 0777, true);
    }
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($need_init) {
        if (file_exists(__DIR__ . '/schema.sql')) {
            $schema = file_get_contents(__DIR__ . '/schema.sql');
            $pdo->exec($schema);
        }
    }
} catch (Exception $e) {
    // In production, log this instead of echoing.
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
