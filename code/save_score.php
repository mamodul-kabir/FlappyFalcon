<?php
session_start(); 
include "db_connect.php"; 

if(!isset($_SESSION["user_id"])){
    exit;
}

$arr = json_decode(file_get_contents("php://input"), true);
$score = isset($arr["score"]) ? intval($arr["score"]) : 0;
$user_id = $_SESSION["user_id"];

$stmt = $db->prepare("UPDATE users SET total_coins = total_coins + :score WHERE id = :id");
$stmt->bindValue(":score", $score, SQLITE3_INTEGER); 
$stmt->bindValue(":id", $user_id, SQLITE3_INTEGER); 
$stmt->execute(); 

if($score > $_SESSION["high_score"]){
    $_SESSION["high_score"] = $score;
    $stmt = $db->prepare("UPDATE users SET high_score = :score WHERE id = :id");
    $stmt->bindValue(":score", $score, SQLITE3_INTEGER); 
    $stmt->bindValue(":id", $user_id, SQLITE3_INTEGER); 
    $stmt->execute(); 
}

$_SESSION['total_coins'] += $score;

?>