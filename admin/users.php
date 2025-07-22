<?php
// Show all errors for debugging (remove these 3 lines in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
session_start(); // Always call this before using $_SESSION

if (empty($_SESSION['is_admin'])) {
    header("Location: /cosc2956final/index.php");
    exit;
}

// Promote/demote user (before any HTML or includes!)
if (isset($_GET['toggle_admin'])) {
    $uid = intval($_GET['toggle_admin']);
    if ($uid !== $_SESSION['user_id']) { // Prevent self-demotion
        $pdo->prepare("UPDATE users SET is_admin = 1 - is_admin WHERE id=?")->execute([$uid]);
    }
    header("Location: /cosc2956final/admin/users.php");
    exit;
}

// Delete user (before any HTML or includes!)
if (isset($_GET['del'])) {
    $uid = intval($_GET['del']);
    if ($uid !== $_SESSION['user_id']) { // Prevent self-deletion
        $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$uid]);
    }
    header("Location: /cosc2956final/admin/users.php");
    exit;
}

require_once '../includes/header.php'; // Now safe to include HTML

// Fetch all users
$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<h2>User Accounts</h2>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Admin</th>
        <th>Actions</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
        <td>
            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                <a href="?toggle_admin=<?= $user['id'] ?>" class="btn btn-sm <?= $user['is_admin'] ? 'btn-warning' : 'btn-success' ?>">
                    <?= $user['is_admin'] ? 'Demote' : 'Promote' ?> to Admin
                </a>
                <a href="?del=<?= $user['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this user?')">Delete</a>
            <?php else: ?>
                (You)
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>
