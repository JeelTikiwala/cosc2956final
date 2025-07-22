<?php
require_once '../includes/db.php';
require_once '../includes/header.php';
if (empty($_SESSION['is_admin'])) { header("Location: ../index.php"); exit; }
?>
<h2>Admin Dashboard</h2>
<ul>
  <li><a href="products.php">Manage Products</a></li>
  <li><a href="orders.php">View Orders</a></li>
  <li><a href="users.php">Manage User Accounts</a></li>
</ul>
<?php require_once '../includes/footer.php'; ?>
