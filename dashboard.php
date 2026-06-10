<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';
require_login();

$productCount = $pdo->query("SELECT COUNT(*) total FROM products")->fetch()['total'];
$categoryCount = $pdo->query("SELECT COUNT(*) total FROM categories")->fetch()['total'];
$stockIn = $pdo->query("SELECT COALESCE(SUM(quantity),0) total FROM stock_transactions WHERE transaction_type='IN'")->fetch()['total'];
$stockOut = $pdo->query("SELECT COALESCE(SUM(quantity),0) total FROM stock_transactions WHERE transaction_type='OUT'")->fetch()['total'];

include __DIR__ . '/includes/sidebar.php';
?>
<h1>Dashboard</h1>
<div class="card">Welcome, <?= clean($_SESSION['name']) ?></div>
<div class="card">Total Categories: <?= $categoryCount ?></div>
<div class="card">Total Products: <?= $productCount ?></div>
<div class="card">Total Stock In: <?= $stockIn ?></div>
<div class="card">Total Stock Out: <?= $stockOut ?></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
