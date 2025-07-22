<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 6")->fetchAll();
?>
<h2 class="mb-4">Featured Products</h2>
<div class="row g-4">
<?php foreach($products as $p): ?>
  <div class="col-sm-6 col-md-4">
    <div class="card h-100">
      <img src="<?= htmlspecialchars($p['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>" style="height:180px;object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
        <p class="card-text">$<?= number_format($p['price'], 2) ?></p>
        <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">View</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require_once 'includes/footer.php'; ?>
