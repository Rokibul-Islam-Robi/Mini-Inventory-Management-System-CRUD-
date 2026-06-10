<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';
require_login();

$type = 'IN';
$message = "";
$error = "";
$products = $pdo->query("SELECT id, product_name, sku FROM products WHERE status=1 ORDER BY product_name")->fetchAll();

function get_current_stock($pdo, $product_id) {
    $sql = "SELECT 
                p.opening_stock
                + COALESCE(SUM(CASE WHEN st.transaction_type='IN' THEN st.quantity ELSE 0 END),0)
                - COALESCE(SUM(CASE WHEN st.transaction_type='OUT' THEN st.quantity ELSE 0 END),0) AS current_stock
            FROM products p
            LEFT JOIN stock_transactions st ON st.product_id = p.id
            WHERE p.id = ?
            GROUP BY p.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    return (int)$stmt->fetch()['current_stock'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $date = $_POST['transaction_date'];
    $remarks = trim($_POST['remarks']);

    if ($quantity <= 0) {
        $error = "Quantity must be greater than zero.";
    } elseif ($type === 'OUT' && $quantity > get_current_stock($pdo, $product_id)) {
        $error = "Stock out quantity cannot be greater than current stock.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO stock_transactions
            (product_id, transaction_type, quantity, transaction_date, remarks, created_by)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$product_id, $type, $quantity, $date, $remarks, current_user_id()]);
        $message = "Stock transaction saved successfully.";
    }
}

include __DIR__ . '/../includes/sidebar.php';
?>
<h1>Stock <?= $type === 'IN' ? 'In' : 'Out' ?></h1>
<div class="card">
<?php if ($message): ?><p class="success"><?= clean($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= clean($error) ?></p><?php endif; ?>
<form method="POST">
    <label>Product</label>
    <select class="form-control" name="product_id" required>
        <option value="">Select Product</option>
        <?php foreach ($products as $p): ?>
            <option value="<?= $p['id'] ?>"><?= clean($p['product_name']) ?> - <?= clean($p['sku']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Quantity</label>
    <input class="form-control" type="number" name="quantity" min="1" required>

    <label>Date</label>
    <input class="form-control" type="date" name="transaction_date" value="<?= date('Y-m-d') ?>" required>

    <label>Remarks</label>
    <input class="form-control" type="text" name="remarks">

    <button class="btn" type="submit">Save</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
