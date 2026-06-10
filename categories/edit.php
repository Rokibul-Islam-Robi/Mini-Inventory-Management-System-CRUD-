<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    die("Category not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['category_name']);
    $description = trim($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE categories SET category_name=?, description=?, status=? WHERE id=?");
    $stmt->execute([$name, $description, $status, $id]);
    redirect("index.php");
}
include __DIR__ . '/../includes/sidebar.php';
?>
<h1>Edit Category</h1>
<div class="card">
<form method="POST">
    <label>Category Name</label>
    <input class="form-control" type="text" name="category_name" value="<?= clean($category['category_name']) ?>" required>
    <label>Description</label>
    <textarea class="form-control" name="description"><?= clean($category['description']) ?></textarea>
    <label><input type="checkbox" name="status" <?= $category['status'] ? 'checked' : '' ?>> Active</label><br><br>
    <button class="btn" type="submit">Update</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
