<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        redirect("/mini_inventory_management_system/dashboard.php");
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Inventory</title>
    <link rel="stylesheet" href="/mini_inventory_management_system/assets/css/style.css">
</head>
<body>
<div class="card login-box">
    <h2>Login</h2>
    <?php if ($error): ?><p class="error"><?= clean($error) ?></p><?php endif; ?>
    <form method="POST">
        <label>Username</label>
        <input class="form-control" type="text" name="username" required>
        <label>Password</label>
        <input class="form-control" type="password" name="password" required>
        <button class="btn" type="submit">Login</button>
    </form>
    <p>Default: admin / password</p>
</div>
</body>
</html>
