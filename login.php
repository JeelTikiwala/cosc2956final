<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<h2>Login</h2>
<form method="post">
  <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
  <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
  <button class="btn btn-primary" type="submit">Login</button>
</form>
<?php if($error) echo "<div class='alert alert-danger mt-2'>$error</div>"; ?>
<?php require_once 'includes/footer.php'; ?>
