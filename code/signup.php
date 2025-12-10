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
    $insert = $db->prepare("INSERT INTO users (username, password) VALUES (:uname, :pw)");
    $insert->bindValue(':uname', $uname, SQLITE3_TEXT);
    $insert->bindValue(':pw', $hashed_pw, SQLITE3_TEXT);

    if ($insert->execute()) {
        header('Location: login_page.php?success=1');
        exit;
    }
    else {
        header('Location: signup_page.php?error=failed');
        exit;
    }
}
?>