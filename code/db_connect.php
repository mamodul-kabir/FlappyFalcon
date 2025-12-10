<?php
$db = new SQLite3( "flappyfalcon.db");

// Enable foreign keys (SQLite requires this to be enabled)
$db->exec("PRAGMA foreign_keys = ON");

// Create users table if it doesn't exist
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL, 
    total_coins INTEGER DEFAULT 0, 
    high_score INTEGER DEFAULT 0
)");

// Check if selected_skin column exists, if not add it
$tableInfo = $db->query("PRAGMA table_info(users)");
$hasSelectedSkin = false;
while ($row = $tableInfo->fetchArray(SQLITE3_ASSOC)) {
    if ($row['name'] == 'selected_skin') {
        $hasSelectedSkin = true;
        break;
    }
}
if (!$hasSelectedSkin) {
    $db->exec("ALTER TABLE users ADD COLUMN selected_skin INTEGER DEFAULT 1");
    // Set default for existing users
    $db->exec("UPDATE users SET selected_skin = 1 WHERE selected_skin IS NULL");
}

// Create user_skins table to store purchased skins
$db->exec("CREATE TABLE IF NOT EXISTS user_skins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    skin_id INTEGER NOT NULL,
    purchased_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, skin_id)
)");

// Ensure all users have the default skin (skin_id = 1) owned
$db->exec("INSERT OR IGNORE INTO user_skins (user_id, skin_id) 
           SELECT id, 1 FROM users WHERE id NOT IN 
           (SELECT user_id FROM user_skins WHERE skin_id = 1)");

?>