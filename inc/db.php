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
        $migrations = [
            'contacts' => 'archived INTEGER DEFAULT 0',
            'users' => 'force_password_change INTEGER DEFAULT 0',
            'events' => [
                'event_type TEXT DEFAULT \'match\'',
                'home_team TEXT',
                'away_team TEXT',
                'home_score INTEGER',
                'away_score INTEGER',
                'status TEXT DEFAULT \'scheduled\''
            ]
        ];
        
        foreach ($migrations as $table => $cols) {
            $stmt = $pdo->prepare("PRAGMA table_info($table)");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $col_names = array_column($columns, 'name');
            
            $col_array = is_array($cols) ? $cols : [$cols];
            foreach ($col_array as $col_def) {
                $col_name = explode(' ', $col_def)[0];
                if (!in_array($col_name, $col_names)) {
                    try {
                        $pdo->exec("ALTER TABLE $table ADD COLUMN $col_def");
                    } catch (Exception $e) {
                        // Column may already exist
                    }
                }
            }
        }
        
        // Create missing tables
        $tables = ['gallery', 'memberships', 'referees', 'courses', 'sponsors', 'newsletter_subscribers'];
        foreach ($tables as $table) {
            $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=?");
            $stmt->execute([$table]);
            if (!$stmt->fetch()) {
                // Create table logic - read from schema and extract
                $schema_file = file_get_contents(__DIR__ . '/schema.sql');
                if (preg_match("/CREATE TABLE IF NOT EXISTS $table \(.*?\);/s", $schema_file, $matches)) {
                    $pdo->exec($matches[0]);
                }
            }
        }
    }
} catch (Exception $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
