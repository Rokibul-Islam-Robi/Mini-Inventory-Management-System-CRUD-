<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();
include __DIR__ . '/../includes/sidebar.php';

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll();
?>
<h1>Product Category</h1>
<a class="btn no-print" href="create.php">Add Category</a>
<div class="card">
<table>
    <tr>
        <th>ID</th><th>Name</th><th>Description</th><th>Status</th><th class="no-print">Action</th>
    </tr>
    <?php foreach ($categories as $cat): ?>
    <tr>
        <td><?= $cat['id'] ?></td>
        <td><?= clean($cat['category_name']) ?></td>
        <td><?= clean($cat['description']) ?></td>
        <td><?= $cat['status'] ? 'Active' : 'Inactive' ?></td>
        <td class="no-print">
            <a class="btn" href="edit.php?id=<?= $cat['id'] ?>">Edit</a>
            <a class="btn btn-danger" onclick="return confirm('Delete this category?')" href="delete.php?id=<?= $cat['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
