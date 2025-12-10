<?php
$path = ""; 
$db = new SQLite3($path . "/flappyfalcon.db");

// Create users table if it doesn't exist
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL, 
    total_coins INTEGER DEFAULT 0, 
    high_score INTEGER DEFAULT 0
)");

//add a new table for inventory/shop

?>