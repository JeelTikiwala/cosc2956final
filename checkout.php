<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $pdo->prepare("SELECT cart.*, products.price, products.stock, products.name FROM cart 
    JOIN products ON cart.product_id = products.id WHERE cart.user_id=?");
$stmt->execute([$user_id]);
$cart = $stmt->fetchAll();

if (!$cart) {
    echo "<div class='alert alert-info'>Cart is empty.</div>";
    require_once 'includes/footer.php';
    exit;
}

$total = 0;
foreach ($cart as $item) {
    if ($item['quantity'] > $item['stock']) {
        echo "<div class='alert alert-danger'>Not enough stock for ".$item['name']."</div>";
        require_once 'includes/footer.php';
        exit;
    }
    $total += $item['price'] * $item['quantity'];
}

// Place order
$pdo->beginTransaction();
$stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->execute([$user_id, $total]);
$order_id = $pdo->lastInsertId();

$stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
$stmt_stock = $pdo->prepare("UPDATE products SET stock=stock-? WHERE id=?");

foreach ($cart as $item) {
    $stmt_item->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
    $stmt_stock->execute([$item['quantity'], $item['product_id']]);
}

// Clear cart
$pdo->prepare("DELETE FROM cart WHERE user_id=?")->execute([$user_id]);
$pdo->commit();

// Redirect to payment page
header("Location: payments.php?order_id=" . $order_id);
exit;
?>
