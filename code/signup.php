<?php
include 'db_connect.php';

if (isset($_POST["signup"])) {
    $uname = trim($_POST["uname"]);
    $pw = $_POST["pw"];
    
    // Basic validation
    if (empty($uname) || empty($pw)) {
        header('Location: signup_page.php?error=empty');
        exit;
    }
    
    // Check if username already exists
    $check = $db->prepare("SELECT * FROM users WHERE username = :uname");
    $check->bindValue(':uname', $uname, SQLITE3_TEXT);
    $result = $check->execute();

    if ($result->fetchArray(SQLITE3_ASSOC)){
        header('Location: signup_page.php?error=exists');
        exit;
    }

    // Fix the insert query
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);
    $insert = $db->prepare("INSERT INTO users (username, password, selected_skin) VALUES (:uname, :pw, 1)");
    $insert->bindValue(':uname', $uname, SQLITE3_TEXT);
    $insert->bindValue(':pw', $hashed_pw, SQLITE3_TEXT);

    $result = $insert->execute();
    if ($result) {
        // Get the new user's ID
        $new_user_id = $db->lastInsertRowID();
        
        // Add default skin (id=1) to user_skins
        $stmt = $db->prepare("INSERT OR IGNORE INTO user_skins (user_id, skin_id) VALUES (:user_id, 1)");
        $stmt->bindValue(':user_id', $new_user_id, SQLITE3_INTEGER);
        $stmt->execute();
        
        header('Location: login_page.php?success=1');
        exit;
    }
    else {
        // Log error for debugging (remove in production or log to file)
        error_log("Signup error: " . $db->lastErrorMsg());
        header('Location: signup_page.php?error=failed');
        exit;
    }
}
?>