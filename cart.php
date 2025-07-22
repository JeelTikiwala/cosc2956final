<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$user_id = $_SESSION['user_id'];
if (isset($_GET['remove'])) {
    $pdo->prepare("DELETE FROM cart WHERE id=? AND user_id=?")->execute([intval($_GET['remove']), $user_id]);
}

$stmt = $pdo->prepare("SELECT cart.*, products.name, products.price, products.image_url FROM cart 
    JOIN products ON cart.product_id = products.id WHERE cart.user_id=?");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();
$total = 0;
?>
<h2>My Cart</h2>
<?php if (!$items): ?>
  <p>Your cart is empty.</p>
<?php else: ?>
<form method="post" action="checkout.php">
<table class="table table-bordered">
  <tr>
    <th>Product</th><th>Image</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Remove</th>
  </tr>
  <?php foreach($items as $item):
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
  ?>
  <tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td><img src="<?= htmlspecialchars($item['image_url']) ?>" width="60"></td>
    <td>$<?= number_format($item['price'],2) ?></td>
    <td><?= $item['quantity'] ?></td>
    <td>$<?= number_format($subtotal,2) ?></td>
    <td><a href="?remove=<?= $item['id'] ?>" class="btn btn-danger btn-sm">X</a></td>
  </tr>
  <?php endforeach; ?>
  <tr>
    <td colspan="4" class="text-end"><b>Total:</b></td>
    <td colspan="2"><b>$<?= number_format($total,2) ?></b></td>
  </tr>
</table>
<button type="submit" class="btn btn-success">Checkout</button>
</form>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
