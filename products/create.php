<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();

$categories = $pdo->query("SELECT * FROM categories WHERE status=1 ORDER BY category_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO products (category_id, product_name, sku, unit, opening_stock, status)
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        (int)$_POST['category_id'],
        trim($_POST['product_name']),
        trim($_POST['sku']),
        trim($_POST['unit']),
        (int)$_POST['opening_stock'],
        isset($_POST['status']) ? 1 : 0
    ]);
    redirect("index.php");
}
include __DIR__ . '/../includes/sidebar.php';
?>
<h1>Add Product</h1>
<div class="card">
<form method="POST">
    <label>Category</label>
    <select class="form-control" name="category_id" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= clean($cat['category_name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Product Name</label>
    <input class="form-control" type="text" name="product_name" required>

    <label>SKU</label>
    <input class="form-control" type="text" name="sku" required>

    <label>Unit</label>
    <input class="form-control" type="text" name="unit" value="pcs" required>

    <label>Opening Stock</label>
    <input class="form-control" type="number" name="opening_stock" min="0" value="0" required>

    <label><input type="checkbox" name="status" checked> Active</label><br><br>
    <button class="btn" type="submit">Save</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
