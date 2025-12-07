<?php
session_start();
$products = include __DIR__ . '/products.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])){
    // Process purchase: add to owned_skins and clear cart
    if(!isset($_SESSION['owned_skins'])) $_SESSION['owned_skins'] = [];
    foreach($cart as $id=>$qty){
        if(isset($products[$id])){
            // add id once (ownership), ignore qty for cosmetics
            $_SESSION['owned_skins'][$id] = true;
            // optionally set last purchased as selected
            $_SESSION['selected_skin'] = $id;
        }
    }
    // clear cart
    unset($_SESSION['cart']);

    // show confirmation
    $message = 'Purchase successful! Your selected skin has been applied.';
}

$stylesheet_url = 'css/index.css'; 
$add_line = '<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">'; 
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
