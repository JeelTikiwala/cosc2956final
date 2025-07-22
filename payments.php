<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Optional: Fetch order details for this user and the provided order_id
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$order = null;
if ($order_id && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?");
    $stmt->execute([$order_id, $_SESSION['user_id']]);
    $order = $stmt->fetch();
}
?>

<div class="container mt-5">
  <div class="card mx-auto" style="max-width:400px;">
    <div class="card-body">
      <h2 class="card-title text-success">Payment</h2>
      <?php if ($order): ?>
        <p>Order <strong>#<?= $order['id'] ?></strong><br>
        Total: <strong>$<?= number_format($order['total_price'],2) ?></strong></p>
      <?php endif; ?>
      <p>Please enter your payment details:</p>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<div class='alert alert-success mt-3'>Payment received! Your order is complete. Thank you!</div>";
      } else {
      ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Card Number</label>
          <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19" required>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Expiry</label>
            <input type="text" class="form-control" placeholder="MM/YY" maxlength="5" required>
          </div>
          <div class="col">
            <label class="form-label">CVV</label>
            <input type="text" class="form-control" placeholder="123" maxlength="4" required>
          </div>
        </div>
        <button type="submit" class="btn btn-success w-100">Pay Now</button>
      </form>
      <?php } ?>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>
