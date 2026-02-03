<?php
if (empty($_SESSION['user'])) {
    header('Location: /signin?redirect=/checkout');
    exit;
}

require __DIR__ . '/../Models/Product.php';
require __DIR__ . '/../Models/Order.php';

$user = $_SESSION['user'];
$useCheckoutItems = !empty($_SESSION['checkout_items']);
$cartSource = $useCheckoutItems ? $_SESSION['checkout_items'] : ($_SESSION['cart']['items'] ?? []);

if (empty($cartSource)) {
    header('Location: /cart');
    exit;
}

if ($useCheckoutItems) {
    $itemsMap = [];
    foreach ($cartSource as $entry) {
        $pid = (int) ($entry['product_id'] ?? 0);
        if ($pid <= 0) {
            continue;
        }
        $itemsMap[$pid] = max(1, (int) ($entry['quantity'] ?? 1));
    }
} else {
    $itemsMap = [];
    foreach ($cartSource as $pid => $qty) {
        $itemsMap[(int) $pid] = max(1, (int) $qty);
    }
}

if (empty($itemsMap)) {
    header('Location: /cart');
    exit;
}

$ids = array_keys($itemsMap);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$byId = [];
foreach ($products as $product) {
    $byId[(int) $product['id']] = $product;
}

$checkoutItems = [];
$totalHt = 0.0;
foreach ($itemsMap as $id => $qty) {
    if (!isset($byId[$id])) {
        continue;
    }
    $product = $byId[$id];
    $price = (float) ($product['price'] ?? 0);
    $lineTotal = $price * $qty;
    $totalHt += $lineTotal;
    $checkoutItems[] = [
        'id' => $id,
        'name' => $product['name'] ?? 'Produit',
        'price' => $price,
        'image' => $product['image'] ?? '',
        'quantity' => $qty,
        'line_total' => $lineTotal
    ];
}

if (empty($checkoutItems)) {
    header('Location: /cart');
    exit;
}

$taxRate = 0.20;
$taxAmount = $totalHt * $taxRate;
$totalTtc = $totalHt + $taxAmount;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'confirm') {
    $orderId = Order::create($pdo, $user, $checkoutItems, $totalTtc);

    if ($useCheckoutItems) {
        unset($_SESSION['checkout_items']);
    } else {
        unset($_SESSION['cart']);
    }

    $_SESSION['last_order_id'] = $orderId;
    header('Location: /thank-you');
    exit;
}

$stmt = $pdo->prepare("SELECT firstname, lastname, email, phone, postal, town, address, country FROM users WHERE id = ? LIMIT 1");
$stmt->execute([(int) $user['id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

require __DIR__ . '/../Views/checkout.php';
