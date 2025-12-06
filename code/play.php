<?php
    $stylesheet_url = 'css/index.css'; 
    $add_line = ['<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">', '<link rel="stylesheet" href="css/flappy.css">' ,'<script src="js/game.js"></script>']; 
    include 'header.php';           

?>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item active"><a href="#">Play</a></li>
            <li class="nav-item"><a href="shop.php">Shop</a></li>
            <li class="nav-item"><a href="lboard.php">Leaderboard</a></li>
        </ul>
    </nav>
    <div class="content">
        <canvas id="screen"></canvas>
    </div>
<?php
    include "footer.php"; 
?>