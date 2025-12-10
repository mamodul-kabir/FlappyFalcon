<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: login_page.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: shop.php');
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$qty = 1;
$update = isset($_POST['update']); 

if($id <= 0){
    header('Location: shop.php');
    exit;
}

$products = include __DIR__ . '/products.php';
if(!isset($products[$id])){
    header('Location: shop.php');
    exit;
}

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if(isset($_SESSION['owned_skins']) && isset($_SESSION['owned_skins'][$id])){
    header('Location: shop.php');
    exit;
}

$_SESSION['cart'][$id] = 1;

header('Location: cart.php');
exit;

