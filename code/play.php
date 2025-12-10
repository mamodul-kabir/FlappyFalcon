<?php
session_start();

// Require login to access this page
if (!isset($_SESSION["username"])) {
    header('Location: login_page.php');
    exit;
}

// Load products to get skin image path
$products = include __DIR__ . '/products.php';
$selected_skin_id = isset($_SESSION['selected_skin']) ? intval($_SESSION['selected_skin']) : 1;
$selected_skin_image = isset($products[$selected_skin_id]) ? $products[$selected_skin_id]['image'] : 'assets/skin/flappybird0.png';

$stylesheet_url = 'css/index.css'; 
$add_line = [
    '<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">',
    '<link rel="stylesheet" href="css/flappy.css">',
    '<script>var selectedSkinImage = "' . htmlspecialchars($selected_skin_image, ENT_QUOTES) . '";</script>',
    '<script src="js/game.js"></script>',
    '<style>body { background: url("assets/8bit_background.jpg") no-repeat center center fixed; background-size: cover; }</style>'
]; 
include 'header.php';           
?>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item active"><a href="#">Play</a></li>
            <li class="nav-item"><a href="shop.php">Shop</a></li>
            <li class="nav-item"><a href="lboard.php">Leaderboard</a></li>
        </ul>
        <div class="user-dropdown">
            <button class="user-dropdown-toggle" onclick="toggleDropdown()">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </button>
            <ul class="user-dropdown-menu">
                <li><a href="logout.php">Sign Out</a></li>
            </ul>
        </div>
    </nav>
    <script>
        function toggleDropdown() {
            document.querySelector('.user-dropdown').classList.toggle('active');
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.user-dropdown');
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
    <div class="content">
        <canvas id="screen"></canvas>
    </div>
<?php
    include "footer.php"; 
?>