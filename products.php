<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$cat = $_GET['category'] ?? '';

$sql = "SELECT * FROM products WHERE 1";
$params = [];
if ($search) {
  $sql .= " AND name LIKE ?";
  $params[] = "%$search%";
}
if ($cat) {
  $sql .= " AND category = ?";
  $params[] = $cat;
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>
<h2>Browse Products</h2>
<form class="row g-3 mb-4" method="get">
  <div class="col-md-5">
    <input type="text" class="form-control" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
  </div>
  <div class="col-md-4">
    <select name="category" class="form-select">
      <option value="">All Categories</option>
      <?php
      $cats = $pdo->query("SELECT DISTINCT category FROM products")->fetchAll(PDO::FETCH_COLUMN);
      foreach ($cats as $c) {
        $sel = $cat == $c ? "selected" : "";
        echo "<option $sel>" . htmlspecialchars($c) . "</option>";
      }
      ?>
    </select>
  </div>
  <div class="col-md-3">
    <button class="btn btn-primary w-100" type="submit">Filter</button>
  </div>
</form>
<div class="row g-4">
<?php if (empty($products)): ?>
  <div class="col-12"><div class="alert alert-info">No products found.</div></div>
<?php endif; ?>
<?php foreach($products as $p): ?>
  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card h-100">
      <img src="<?= htmlspecialchars($p['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>" style="height:150px;object-fit:cover;">
      <div class="card-body">
        <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
        <p class="card-text">$<?= number_format($p['price'], 2) ?></p>
        <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">View</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require_once 'includes/footer.php'; ?>
