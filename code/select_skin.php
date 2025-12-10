<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: login_page.php');
    exit;
}

include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: shop.php');
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if($id <= 0){ header('Location: shop.php'); exit; }

$products = include __DIR__ . '/products.php';
if(!isset($products[$id])){ header('Location: shop.php'); exit; }

if(isset($_SESSION['owned_skins']) && isset($_SESSION['owned_skins'][$id])){
    $_SESSION['selected_skin'] = $id;
    
    // Save selected skin to database
    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
        $stmt = $db->prepare("UPDATE users SET selected_skin = :skin_id WHERE id = :id");
        $stmt->bindValue(':skin_id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        if(!$result){
            // Log error for debugging
            error_log("Select skin error: " . $db->lastErrorMsg());
        }
    }
}

header('Location: shop.php');
exit;
