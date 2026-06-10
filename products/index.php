<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();
include __DIR__ . '/../includes/sidebar.php';

$sql = "SELECT p.*, c.category_name
        FROM products p
        JOIN categories c ON c.id = p.category_id
        ORDER BY p.id DESC";
$products = $pdo->query($sql)->fetchAll();
?>
<h1>Product Entry</h1>
<a class="btn no-print" href="create.php">Add Product</a>
<div class="card">
<table>
<tr>
    <th>ID</th><th>Category</th><th>Product</th><th>SKU</th><th>Unit</th><th>Opening Stock</th><th>Status</th><th class="no-print">Action</th>
</tr>
<?php foreach ($products as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= clean($p['category_name']) ?></td>
    <td><?= clean($p['product_name']) ?></td>
    <td><?= clean($p['sku']) ?></td>
    <td><?= clean($p['unit']) ?></td>
    <td><?= $p['opening_stock'] ?></td>
    <td><?= $p['status'] ? 'Active' : 'Inactive' ?></td>
    <td class="no-print">
        <a class="btn" href="edit.php?id=<?= $p['id'] ?>">Edit</a>
        <a class="btn btn-danger" onclick="return confirm('Delete this product?')" href="delete.php?id=<?= $p['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
