<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$name || !$email || !$password || !$confirm) $errors[] = "All fields required.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) $errors[] = "Email already registered.";
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);
        echo "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login now</a></div>";
    }
}
?>
<h2>Register</h2>
<form method="post">
  <input class="form-control mb-2" type="text" name="name" placeholder="Full Name" required>
  <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
  <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
  <input class="form-control mb-2" type="password" name="confirm" placeholder="Confirm Password" required>
  <button class="btn btn-primary" type="submit">Register</button>
</form>
<?php if($errors) foreach($errors as $e) echo "<div class='alert alert-danger mt-2'>$e</div>"; ?>
<?php require_once 'includes/footer.php'; ?>
