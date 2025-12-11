<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: login_page.php');
    exit;
}
include 'db_connect.php';
$products = include __DIR__ . '/products.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])){
    $total = 0;
    foreach($cart as $id=>$qty){
        if(isset($products[$id])){
            $total += $products[$id]['price'];
        }
    }
    
    $user_id = $_SESSION["user_id"];
    $stmt = $db->prepare("SELECT total_coins FROM users WHERE id = :id");
    $stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    
    if($user && $user['total_coins'] >= $total){
        $stmt = $db->prepare("UPDATE users SET total_coins = total_coins - :total WHERE id = :id");
        $stmt->bindValue(':total', $total, SQLITE3_INTEGER);
        $stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
        $stmt->execute();
        
        $_SESSION['total_coins'] = $user['total_coins'] - $total;
        
        if(!isset($_SESSION['owned_skins'])) $_SESSION['owned_skins'] = [];
        $last_purchased_id = null;
        
        foreach($cart as $id=>$qty){
            if(isset($products[$id])){
                $stmt = $db->prepare("INSERT OR IGNORE INTO user_skins (user_id, skin_id) VALUES (:user_id, :skin_id)");
                $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
                $stmt->bindValue(':skin_id', $id, SQLITE3_INTEGER);
                $stmt->execute();
                
                // Update session
                $_SESSION['owned_skins'][$id] = true;
                $last_purchased_id = $id;
            }
        }
        
        if($last_purchased_id !== null){
            $stmt = $db->prepare("UPDATE users SET selected_skin = :skin_id WHERE id = :id");
            $stmt->bindValue(':skin_id', $last_purchased_id, SQLITE3_INTEGER);
            $stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
            $stmt->execute();
            $_SESSION['selected_skin'] = $last_purchased_id;
        }
        
        unset($_SESSION['cart']);

        $message = 'Purchase successful! Your selected skin has been applied.';
    } else {
        $message = 'Insufficient coins! You need ' . $total . ' coins but only have ' . ($user ? $user['total_coins'] : 0) . ' coins.';
    }
}

$stylesheet_url = 'css/index.css'; 
$add_line = ['<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">']; 
include 'header.php';
?>

<div class="content">
    <h1>Checkout</h1>

    <?php if(empty($cart) && !isset($message)): ?>
        <p>Your cart is empty. <a href="shop.php">Shop now</a></p>
    <?php else: ?>
        <?php if(isset($message)): ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
            <p><a href="play.php">Go play</a> or <a href="shop.php">back to shop</a></p>
        <?php else: ?>
            <h2>Order Summary</h2>
            <ul>
            <?php $total=0; foreach($cart as $id=>$qty): if(!isset($products[$id])) continue; $p=$products[$id]; $sub=$p['price']*$qty; $total+=$sub; ?>
                <li><?php echo htmlspecialchars($p['name'])." x $qty — ".$p['price'].' each'; ?></li>
            <?php endforeach; ?>
            </ul>
            <p><strong>Total: <?php echo intval($total); ?> coins</strong></p>

            <form method="post">
                <button type="submit" name="confirm" value="1">Confirm Purchase</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>

