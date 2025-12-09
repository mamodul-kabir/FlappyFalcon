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
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$uname]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($pw, $user["password"])) {
        // Set session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        
        header('Location: play.php');
        exit;
    } else {
        header('Location: login_page.php?error=invalid');
        exit;
    }
}