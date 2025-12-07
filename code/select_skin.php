<?php
session_start();

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
}

header('Location: shop.php');
exit;
