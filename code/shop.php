<?php
    session_start();
    $stylesheet_url = 'css/index.css'; 
    $add_line = ['<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">']; 
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
            <li class="nav-item active"><a href="shop.php">Shop</a></li>
            <li class="nav-item"><a href="lboard.php">Leaderboard</a></li>
        </ul>
    </nav>
    <div class="content">
        <h1>Store — Skins</h1>
        <p>Choose a skin and add it to your cart.</p>
        <p><a href="cart.php">View Cart</a></p>

        <?php
            $products = include __DIR__ . '/products.php';
            // Ensure default skin selected is flappybird0 (product id 1)
            if (!isset($_SESSION['selected_skin'])) {
                $_SESSION['selected_skin'] = 1;
            }
            if (!isset($_SESSION['owned_skins'])) {
                // mark default skin as owned so user can select it
                $_SESSION['owned_skins'] = [1 => true];
            } else {
                // ensure default owned
                if (!isset($_SESSION['owned_skins'][1])) {
                    $_SESSION['owned_skins'][1] = true;
                }
            }
        ?>

        <div class="product-grid">
            <?php foreach($products as $p): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="max-width:140px; height:auto;">
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                        <p><?php echo htmlspecialchars($p['desc']); ?></p>
                        <p><strong>Price:</strong> <?php echo $p['price']; ?> coins</p>
                        <?php
                            $owned = isset($_SESSION['owned_skins']) && isset($_SESSION['owned_skins'][$p['id']]);
                            $selected = isset($_SESSION['selected_skin']) && $_SESSION['selected_skin'] == $p['id'];
                        ?>
                        <?php if($owned): ?>
                            <?php if($selected): ?>
                                <p><em>Selected</em></p>
                            <?php else: ?>
                                <form action="select_skin.php" method="post" style="display:inline">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <button type="submit">Select Skin</button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .product-grid{display:flex;flex-wrap:wrap;gap:20px;justify-content:center;align-items:flex-start;padding:24px}
            .product-card{background:#ffffff;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.12);padding:18px;width:240px;display:flex;flex-direction:column;align-items:center}
            .product-image{height:140px;display:flex;align-items:center;justify-content:center;margin-bottom:8px}
            .product-info{text-align:center}
            .product-card h3{margin:8px 0 6px;font-size:14px}
            .product-card p{margin:6px 0;font-size:12px;color:#333}
            .product-card button{background:#57068C;color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer}
            .product-card button:hover{background:#6f12b8}
        </style>
    </div>
<?php
    include "footer.php"; 
?>