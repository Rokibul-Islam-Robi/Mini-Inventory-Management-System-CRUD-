<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['category_name']);
    $description = trim($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO categories (category_name, description, status) VALUES (?, ?, ?)");
    $stmt->execute([$name, $description, $status]);
    redirect("index.php");
}
include __DIR__ . '/../includes/sidebar.php';
?>
<h1>Add Category</h1>
<div class="card">
<form method="POST">
    <label>Category Name</label>
    <input class="form-control" type="text" name="category_name" required>
    <label>Description</label>
    <textarea class="form-control" name="description"></textarea>
    <label><input type="checkbox" name="status" checked> Active</label><br><br>
    <button class="btn" type="submit">Save</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
