<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();
include __DIR__ . '/../includes/sidebar.php';

$sql = "SELECT 
            p.id,
            c.category_name,
            p.product_name,
            p.sku,
            p.unit,
            p.opening_stock,
            COALESCE(SUM(CASE WHEN st.transaction_type='IN' THEN st.quantity ELSE 0 END),0) AS stock_in,
            COALESCE(SUM(CASE WHEN st.transaction_type='OUT' THEN st.quantity ELSE 0 END),0) AS stock_out,
            p.opening_stock
            + COALESCE(SUM(CASE WHEN st.transaction_type='IN' THEN st.quantity ELSE 0 END),0)
            - COALESCE(SUM(CASE WHEN st.transaction_type='OUT' THEN st.quantity ELSE 0 END),0) AS current_stock
        FROM products p
        JOIN categories c ON c.id = p.category_id
        LEFT JOIN stock_transactions st ON st.product_id = p.id
        GROUP BY p.id
        ORDER BY p.product_name";
$rows = $pdo->query($sql)->fetchAll();
?>
<h1>Current Stock Report</h1>
<button class="btn no-print" onclick="printPage()">Print</button>
<div class="card">
<table>
<tr>
    <th>Category</th><th>Product</th><th>SKU</th><th>Unit</th><th>Opening</th><th>Stock In</th><th>Stock Out</th><th>Current Stock</th>
</tr>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= clean($r['category_name']) ?></td>
    <td><?= clean($r['product_name']) ?></td>
    <td><?= clean($r['sku']) ?></td>
    <td><?= clean($r['unit']) ?></td>
    <td><?= $r['opening_stock'] ?></td>
    <td><?= $r['stock_in'] ?></td>
    <td><?= $r['stock_out'] ?></td>
    <td><?= $r['current_stock'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
