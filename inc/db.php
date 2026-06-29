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
        // Initialize from schema
        if (file_exists(__DIR__ . '/schema.sql')) {
            $schema = file_get_contents(__DIR__ . '/schema.sql');
            $pdo->exec($schema);
        }
    } else {
        // Run migrations for existing database
        // Add archived column to contacts if missing
        $stmt = $pdo->prepare("PRAGMA table_info(contacts)");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $col_names = array_column($columns, 'name');
        if (!in_array('archived', $col_names)) {
            $pdo->exec("ALTER TABLE contacts ADD COLUMN archived INTEGER DEFAULT 0");
        }
        // Add force_password_change column to users if missing
        $stmt = $pdo->prepare("PRAGMA table_info(users)");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $col_names = array_column($columns, 'name');
        if (!in_array('force_password_change', $col_names)) {
            $pdo->exec("ALTER TABLE users ADD COLUMN force_password_change INTEGER DEFAULT 0");
        }
    }
} catch (Exception $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
