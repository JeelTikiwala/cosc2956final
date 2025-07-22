<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<div class='alert alert-danger'>Product not found.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity']) && isset($_SESSION['user_id'])) {
    $qty = max(1, intval($_POST['quantity']));
    $user_id = $_SESSION['user_id'];
    $stmt2 = $pdo->prepare("SELECT * FROM cart WHERE user_id=? AND product_id=?");
    $stmt2->execute([$user_id, $id]);
    if ($row = $stmt2->fetch()) {
        $pdo->prepare("UPDATE cart SET quantity=quantity+? WHERE id=?")->execute([$qty, $row['id']]);
    } else {
        $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)")->execute([$user_id, $id, $qty]);
    }
    echo "<div class='alert alert-success'>Added to cart!</div>";
}

// Add review
if (isset($_POST['addreview']) && isset($_SESSION['user_id'])) {
    $rating = max(1, min(5, intval($_POST['rating'])));
    $review = trim($_POST['review']);
    $user_id = $_SESSION['user_id'];
    $pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, review) VALUES (?, ?, ?, ?)")
        ->execute([$id, $user_id, $rating, $review]);
    echo "<div class='alert alert-success'>Review submitted!</div>";
}

// Calculate average rating
$avgStmt = $pdo->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS num_reviews FROM reviews WHERE product_id=?");
$avgStmt->execute([$id]);
$avg = $avgStmt->fetch();
$avg_rating = $avg['avg_rating'] ? round($avg['avg_rating'], 1) : null;
$num_reviews = $avg['num_reviews'] ?? 0;
?>
<div class="row">
  <div class="col-md-6">
    <img src="<?= htmlspecialchars($product['image_url']) ?>" class="img-fluid" alt="">
  </div>
  <div class="col-md-6">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <h4>$<?= number_format($product['price'], 2) ?></h4>
    <p>In stock: <?= $product['stock'] ?></p>
    <?php if ($avg_rating): ?>
      <p>
        <strong>Average rating:</strong>
        <?php
          for ($i = 1; $i <= 5; $i++) {
              echo $i <= round($avg_rating) ? "★" : "☆";
          }
          echo " ({$avg_rating} / 5 from {$num_reviews} review" . ($num_reviews == 1 ? "" : "s") . ")";
        ?>
      </p>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_id'])): ?>
      <form method="post" class="mb-3">
        <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control mb-2" style="width:100px;">
        <button class="btn btn-primary" type="submit">Add to Cart</button>
      </form>
    <?php else: ?>
      <a href="login.php" class="btn btn-info">Login to buy</a>
    <?php endif; ?>
  </div>
</div>

<hr>
<h5>Reviews</h5>
<?php if (isset($_SESSION['user_id'])): ?>
  <form method="post" class="mb-3">
    <div class="row g-2 align-items-center">
      <div class="col-auto">
        <select name="rating" required class="form-select">
          <option value="">Rating</option>
          <?php for ($i=1;$i<=5;$i++) echo "<option>$i</option>"; ?>
        </select>
      </div>
      <div class="col">
        <input type="text" name="review" class="form-control" placeholder="Your review..." required>
      </div>
      <div class="col-auto">
        <button class="btn btn-success btn-sm" type="submit" name="addreview">Submit</button>
      </div>
    </div>
  </form>
<?php endif; ?>

<?php
$reviews = $pdo->prepare("SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id=? ORDER BY r.review_date DESC");
$reviews->execute([$id]);
foreach ($reviews as $r) {
  echo "<div class='border rounded p-2 mb-2'><b>".htmlspecialchars($r['name'])."</b> ";
  echo str_repeat('★', $r['rating']) . str_repeat('☆', 5-$r['rating']) . " ";
  echo "<small class='text-muted'>{$r['review_date']}</small><br>";
  echo nl2br(htmlspecialchars($r['review']));
  echo "</div>";
}
if ($reviews->rowCount() == 0) echo "<div class='alert alert-info'>No reviews yet.</div>";
?>
<?php require_once 'includes/footer.php'; ?>
