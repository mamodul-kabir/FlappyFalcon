<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: login_page.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: cart.php');
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if($id <= 0){
    header('Location: cart.php');
    exit;
}

if(isset($_SESSION['cart'][$id])){
    unset($_SESSION['cart'][$id]);
}

header('Location: cart.php');
exit;
