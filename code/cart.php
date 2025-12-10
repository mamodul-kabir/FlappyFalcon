<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: login_page.php');
    exit;
}
$stylesheet_url = 'css/index.css'; 
$add_line = ['<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">']; 
include 'header.php';

$products = include __DIR__ . '/products.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

function format_coins($n){ return intval($n).' coins'; }
?>

<nav class="navbar">
    <ul class="nav-list">
        <li class="nav-item"><a href="play.php">Play</a></li>
        <li class="nav-item"><a href="shop.php">Shop</a></li>
        <li class="nav-item"><a href="lboard.php">Leaderboard</a></li>
    </ul>
</nav>

<div class="content">
    <h1>Your Cart</h1>
    <p><a href="shop.php">Continue shopping</a></p>

    <?php if(empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="cart-wrap">
            <table class="cart-table">
                <thead>
                    <tr><th>Skin</th><th>Price</th><th>Subtotal</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php $total=0; foreach($cart as $id=>$qty):
                    if(!isset($products[$id])) continue;
                    $p = $products[$id];
                    $sub = $p['price'];
                    $total += $sub;
                ?>
                <tr>
                    <td class="cart-skin">
                        <img src="<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="skin-img" />
                        <div><?php echo htmlspecialchars($p['name']); ?></div>
                    </td>
                    <td><?php echo format_coins($p['price']); ?></td>
                    <td><?php echo format_coins($sub); ?></td>
                    <td>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <p><strong>Total: <?php echo format_coins($total); ?></strong></p>
                <form action="checkout.php" method="post">
                    <button type="submit">Proceed to Checkout</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>

<style>
    .content{max-width:980px;margin:0 auto;padding:24px}
    /* layout: table on the left, summary on the right */
    .cart-wrap{display:grid;grid-template-columns:1fr 280px;gap:24px;align-items:start;justify-content:center}
    .cart-table{border-collapse:collapse;width:100%;background:#fff;border-radius:8px;box-shadow:0 8px 20px rgba(0,0,0,0.06);overflow:hidden}
    .cart-table thead{background:linear-gradient(90deg,#57068C,#7b2dbb);color:#fff}
    .cart-table th,.cart-table td{padding:12px 14px;text-align:left;border-bottom:1px solid #f6f6f6;font-size:13px;vertical-align:middle}
    .cart-skin{display:flex;gap:12px;align-items:center}
    .skin-img{width:56px;height:56px;object-fit:cover;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.08)}
    .cart-skin div{font-size:13px}
    .cart-summary{background:#fff;padding:18px;border-radius:10px;box-shadow:0 8px 20px rgba(0,0,0,0.06);min-width:220px;display:flex;flex-direction:column;gap:12px}
    .cart-summary p{font-size:14px;margin:0}
    .cart-table button,.cart-summary button{background:#57068C;color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer}
    .cart-table button:hover,.cart-summary button:hover{background:#6f12b8}
    /* small screen: stack layout */
    @media(max-width:900px){
        .cart-wrap{grid-template-columns:1fr}
        .cart-summary{order:2}
    }
    @media(max-width:480px){
        .skin-img{width:48px;height:48px}
        .cart-table th,.cart-table td{padding:10px}
    }
</style>

<?php include 'footer.php'; ?>
