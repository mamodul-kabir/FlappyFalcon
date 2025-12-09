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
    $check = $db->prepare("SELECT * FROM users WHERE username = ?");
    $check->execute([$uname]);
    
    if ($check->fetch()) {
        header('Location: signup_page.php?error=exists');
        exit;
    }
    
    // Hash the password and insert
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);
    $insert = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    if ($insert->execute([$uname, $hashed_pw])) {
        header('Location: login_page.php?success=1');
        exit;
    } else {
        header('Location: signup_page.php?error=failed');
        exit;
    }
}
?>