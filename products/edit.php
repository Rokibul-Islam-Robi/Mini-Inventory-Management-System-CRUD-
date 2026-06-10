<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    die("Product not found.");
}

$categories = $pdo->query("SELECT * FROM categories WHERE status=1 ORDER BY category_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE products
                           SET category_id=?, product_name=?, sku=?, unit=?, opening_stock=?, status=?
                           WHERE id=?");
    $stmt->execute([
        (int)$_POST['category_id'],
        trim($_POST['product_name']),
        trim($_POST['sku']),
        trim($_POST['unit']),
        (int)$_POST['opening_stock'],
        isset($_POST['status']) ? 1 : 0,
        $id
    ]);
    redirect("index.php");
}
include __DIR__ . '/../includes/sidebar.php';
?>
<h1>Edit Product</h1>
<div class="card">
<form method="POST">
    <label>Category</label>
    <select class="form-control" name="category_id" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                <?= clean($cat['category_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Product Name</label>
    <input class="form-control" type="text" name="product_name" value="<?= clean($product['product_name']) ?>" required>

    <label>SKU</label>
    <input class="form-control" type="text" name="sku" value="<?= clean($product['sku']) ?>" required>

    <label>Unit</label>
    <input class="form-control" type="text" name="unit" value="<?= clean($product['unit']) ?>" required>

    <label>Opening Stock</label>
    <input class="form-control" type="number" name="opening_stock" min="0" value="<?= $product['opening_stock'] ?>" required>

    <label><input type="checkbox" name="status" <?= $product['status'] ? 'checked' : '' ?>> Active</label><br><br>
    <button class="btn" type="submit">Update</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
