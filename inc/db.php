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
        // Add event_type, home_team, away_team, home_score, away_score, status columns to events if missing
        $stmt = $pdo->prepare("PRAGMA table_info(events)");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $col_names = array_column($columns, 'name');
        if (!in_array('event_type', $col_names)) {
            $pdo->exec("ALTER TABLE events ADD COLUMN event_type TEXT DEFAULT 'match'");
        }
        if (!in_array('home_team', $col_names)) {
            $pdo->exec("ALTER TABLE events ADD COLUMN home_team TEXT");
        }
        if (!in_array('away_team', $col_names)) {
            $pdo->exec("ALTER TABLE events ADD COLUMN away_team TEXT");
        }
        if (!in_array('home_score', $col_names)) {
            $pdo->exec("ALTER TABLE events ADD COLUMN home_score INTEGER");
        }
        if (!in_array('away_score', $col_names)) {
            $pdo->exec("ALTER TABLE events ADD COLUMN away_score INTEGER");
        }
        if (!in_array('status', $col_names)) {
            $pdo->exec("ALTER TABLE events ADD COLUMN status TEXT DEFAULT 'scheduled'");
        }
        // Create teams table if missing
        $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='teams'");
        $stmt->execute();
        if (!$stmt->fetch()) {
            $pdo->exec("CREATE TABLE teams (
              id INTEGER PRIMARY KEY AUTOINCREMENT,
              name TEXT UNIQUE NOT NULL,
              slug TEXT UNIQUE NOT NULL,
              logo TEXT,
              description TEXT,
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
        }
        // Create players table if missing
        $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='players'");
        $stmt->execute();
        if (!$stmt->fetch()) {
            $pdo->exec("CREATE TABLE players (
              id INTEGER PRIMARY KEY AUTOINCREMENT,
              name TEXT NOT NULL,
              team_id INTEGER NOT NULL,
              number INTEGER,
              position TEXT,
              bio TEXT,
              photo TEXT,
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
              FOREIGN KEY(team_id) REFERENCES teams(id) ON DELETE CASCADE
            )");
        }
        // Create standings table if missing
        $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='standings'");
        $stmt->execute();
        if (!$stmt->fetch()) {
            $pdo->exec("CREATE TABLE standings (
              id INTEGER PRIMARY KEY AUTOINCREMENT,
              team_id INTEGER NOT NULL UNIQUE,
              wins INTEGER DEFAULT 0,
              losses INTEGER DEFAULT 0,
              points INTEGER DEFAULT 0,
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
              FOREIGN KEY(team_id) REFERENCES teams(id) ON DELETE CASCADE
            )");
        }
    }
} catch (Exception $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
