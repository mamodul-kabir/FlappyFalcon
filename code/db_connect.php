<?php
$db = new SQLite3( "flappyfalcon.db");

$db->exec("PRAGMA foreign_keys = ON");

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL, 
    total_coins INTEGER DEFAULT 0, 
    high_score INTEGER DEFAULT 0
)");

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
    $db->exec("UPDATE users SET selected_skin = 1 WHERE selected_skin IS NULL");
}

$db->exec("CREATE TABLE IF NOT EXISTS user_skins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    skin_id INTEGER NOT NULL,
    purchased_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, skin_id)
)");

$db->exec("INSERT OR IGNORE INTO user_skins (user_id, skin_id) 
           SELECT id, 1 FROM users WHERE id NOT IN 
           (SELECT user_id FROM user_skins WHERE skin_id = 1)");

?>
