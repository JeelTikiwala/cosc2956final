<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>
<h2>My Orders</h2>
<?php if (!$orders): ?>
  <p>No orders yet.</p>
<?php else: ?>
  <ul class="list-group">
  <?php foreach($orders as $order): ?>
    <li class="list-group-item">
      Order #<?= $order['id'] ?> - $<?= number_format($order['total_price'],2) ?> - <?= $order['order_date'] ?>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
