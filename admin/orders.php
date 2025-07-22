<?php
require_once '../includes/db.php';
require_once '../includes/header.php';
if (empty($_SESSION['is_admin'])) { header("Location: ../index.php"); exit; }
$stmt = $pdo->query("SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.id ORDER BY order_date DESC");
$orders = $stmt->fetchAll();
?>
<h2>All Orders</h2>
<table class="table">
<tr><th>Order #</th><th>User</th><th>Total</th><th>Date</th></tr>
<?php foreach($orders as $order): ?>
<tr>
  <td><?= $order['id'] ?></td>
  <td><?= htmlspecialchars($order['name']) ?></td>
  <td>$<?= number_format($order['total_price'],2) ?></td>
  <td><?= $order['order_date'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>
