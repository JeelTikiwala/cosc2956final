<?php
require_once '../includes/db.php';
require_once '../includes/header.php';
if (empty($_SESSION['is_admin'])) { header("Location: ../index.php"); exit; }

if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category, stock) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'], $_POST['desc'], $_POST['price'], $_POST['image_url'], $_POST['category'], $_POST['stock']
    ]);
}
if (isset($_GET['del'])) {
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([intval($_GET['del'])]);
}
$products = $pdo->query("SELECT * FROM products")->fetchAll();
?>
<h2>Products</h2>
<form method="post" class="mb-4">
  <input name="name" placeholder="Name" required>
  <input name="desc" placeholder="Description" required>
  <input name="price" type="number" step="0.01" placeholder="Price" required>
  <input name="image_url" placeholder="Image URL" required>
  <input name="category" placeholder="Category" required>
  <input name="stock" type="number" placeholder="Stock" required>
  <button class="btn btn-success" name="add" type="submit">Add</button>
</form>
<table class="table">
<tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Action</th></tr>
<?php foreach($products as $p): ?>
<tr>
  <td><?= $p['id'] ?></td>
  <td><?= htmlspecialchars($p['name']) ?></td>
  <td>$<?= $p['price'] ?></td>
  <td><?= $p['stock'] ?></td>
  <td><a href="?del=<?= $p['id'] ?>" onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>
