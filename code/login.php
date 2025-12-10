<?php
    //ADD DB code and others

session_start();
include 'db_connect.php';

if (isset($_POST["login"])) {
    $uname = trim($_POST["uname"]);
    $pw = $_POST["pw"];
    
    // Basic validation
    if (empty($uname) || empty($pw)) {
        header('Location: login_page.php?error=empty');
        exit;
    }
    
    // Look up the user
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :uname");
    $stmt->bindValue(':uname', $uname, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    
    if ($user && password_verify($pw, $user["password"])) {
        // Set session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["total_coins"] = $user["total_coins"]; 
        $_SESSION["high_score"] = $user["high_score"];
        
        // Load selected skin from database (default to 1 if not set)
        $selected_skin = isset($user["selected_skin"]) ? intval($user["selected_skin"]) : 1;
        $_SESSION["selected_skin"] = $selected_skin;
        
        // Load owned skins from database
        $_SESSION["owned_skins"] = [];
        $stmt = $db->prepare("SELECT skin_id FROM user_skins WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $user["id"], SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $_SESSION["owned_skins"][$row["skin_id"]] = true;
        }
        
        // Ensure default skin (id=1) is always owned
        if(!isset($_SESSION["owned_skins"][1])){
            $_SESSION["owned_skins"][1] = true;
            // Also add it to database if missing
            $stmt = $db->prepare("INSERT OR IGNORE INTO user_skins (user_id, skin_id) VALUES (:user_id, 1)");
            $stmt->bindValue(':user_id', $user["id"], SQLITE3_INTEGER);
            $stmt->execute();
        }
        
        header('Location: play.php');
        exit;
    } else {
        header('Location: login_page.php?error=invalid');
        exit;
    }
}