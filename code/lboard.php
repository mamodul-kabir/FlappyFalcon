<?php
    $stylesheet_url = 'css/index.css'; 
    $add_line = '<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">'; 
    include 'header.php';           
    
    /*
    if(!isset($_COOKIE["uname"])){
        header('Location: login.php');
        exit;
    } 
    */
?>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="play.php">Play</a></li>
            <li class="nav-item"><a href="shop.php">Shop</a></li>
            <li class="nav-item active"><a href="#">Leaderboard</a></li>
        </ul>
    </nav>
    <div class="content">
        <h1>Welcome, Player!</h1>
        <p>Prepare for the next level!</p>
    </div>
<?php
    include "footer.php"; 
?>