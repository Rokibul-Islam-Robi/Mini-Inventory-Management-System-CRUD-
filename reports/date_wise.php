<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();
include __DIR__ . '/../includes/sidebar.php';

$from = $_GET['from_date'] ?? date('Y-m-01');
$to = $_GET['to_date'] ?? date('Y-m-d');

$sql = "SELECT 
            st.transaction_date,
            st.transaction_type,
            st.quantity,
            st.remarks,
            p.product_name,
            p.sku,
            c.category_name
        FROM stock_transactions st
        JOIN products p ON p.id = st.product_id
        JOIN categories c ON c.id = p.category_id
        WHERE st.transaction_date BETWEEN ? AND ?
        ORDER BY st.transaction_date DESC, st.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$from, $to]);
$rows = $stmt->fetchAll();
?>
<h1>Date-wise Report</h1>
<div class="card no-print">
<form method="GET">
    <label>From Date</label>
    <input class="form-control" type="date" name="from_date" value="<?= clean($from) ?>">
    <label>To Date</label>
    <input class="form-control" type="date" name="to_date" value="<?= clean($to) ?>">
    <button class="btn" type="submit">Search</button>
    <button class="btn btn-secondary" type="button" onclick="printPage()">Print</button>
</form>
</div>
<div class="card">
<h3>Report From <?= clean($from) ?> To <?= clean($to) ?></h3>
<table>
<tr>
    <th>Date</th><th>Category</th><th>Product</th><th>SKU</th><th>Type</th><th>Quantity</th><th>Remarks</th>
</tr>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= clean($r['transaction_date']) ?></td>
    <td><?= clean($r['category_name']) ?></td>
    <td><?= clean($r['product_name']) ?></td>
    <td><?= clean($r['sku']) ?></td>
    <td><?= clean($r['transaction_type']) ?></td>
    <td><?= $r['quantity'] ?></td>
    <td><?= clean($r['remarks']) ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
