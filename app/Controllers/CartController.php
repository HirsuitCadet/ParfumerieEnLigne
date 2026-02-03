<?php
require __DIR__ . '/../Models/Product.php';

function cart_clamp_qty(int $qty): int {
    return $qty > 0 ? $qty : 1;
}

function cart_get_max_qty(?int $stock): int {
    if ($stock === null) {
        return 99;
    }
    return max(0, $stock);
}

function cart_add_item(int $productId, int $qty, int $maxQty): void {
    if (!isset($_SESSION['cart']['items']) || !is_array($_SESSION['cart']['items'])) {
        $_SESSION['cart'] = ['items' => []];
    }
    $current = (int)($_SESSION['cart']['items'][$productId] ?? 0);
    $newQty = $current + $qty;
    if ($newQty > $maxQty) {
        $newQty = $maxQty;
    }
    $_SESSION['cart']['items'][$productId] = $newQty;
}

function cart_redirect_back(string $fallback = '/cart'): void {
    $ref = $_SERVER['HTTP_REFERER'] ?? '';
    if ($ref !== '') {
        header('Location: ' . $ref);
        exit;
    }
    header('Location: ' . $fallback);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $qty = cart_clamp_qty((int)($_POST['quantity'] ?? 1));

    if (!$productId || !in_array($action, ['add', 'buy', 'update', 'remove'], true)) {
        cart_redirect_back();
    }

    if (empty($_SESSION['user'])) {
        $_SESSION['pending_cart_action'] = [
            'action' => $action,
            'product_id' => $productId,
            'quantity' => $qty
        ];
        $_SESSION['redirect_after_login'] = ($action === 'buy') ? '/checkout' : ('/product?id=' . $productId);
        header('Location: /signin?redirect=' . urlencode($_SESSION['redirect_after_login']));
        exit;
    }

    if ($action === 'remove') {
        if (isset($_SESSION['cart']['items'][$productId])) {
            unset($_SESSION['cart']['items'][$productId]);
        }
        cart_redirect_back();
    }

    $product = Product::find($pdo, $productId);
    if (!$product) {
        http_response_code(404);
        echo "Produit introuvable";
        exit;
    }

    $stock = isset($product['stock']) ? (int)$product['stock'] : null;
    $maxQty = cart_get_max_qty($stock);
    if ($maxQty <= 0) {
        cart_redirect_back();
    }
    if ($qty > $maxQty) {
        $qty = $maxQty;
    }

    if ($action === 'update') {
        if (!isset($_SESSION['cart']['items']) || !is_array($_SESSION['cart']['items'])) {
            $_SESSION['cart'] = ['items' => []];
        }
        $_SESSION['cart']['items'][$productId] = $qty;
        cart_redirect_back();
    }

    if ($action === 'add') {
        cart_add_item($productId, $qty, $maxQty);
        cart_redirect_back();
    }

    $_SESSION['checkout_items'] = [
        [
            'product_id' => $productId,
            'quantity' => $qty
        ]
    ];
    header('Location: /checkout');
    exit;
}

if (empty($_SESSION['user'])) {
    header('Location: /signin?redirect=/cart');
    exit;
}

$items = $_SESSION['cart']['items'] ?? [];
$cartItems = [];
$cartTotal = 0.0;

if (!empty($items)) {
    $ids = array_keys($items);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $byId = [];
    foreach ($products as $product) {
        $byId[(int)$product['id']] = $product;
    }

    foreach ($items as $id => $quantity) {
        $id = (int)$id;
        if (!isset($byId[$id])) {
            continue;
        }
        $product = $byId[$id];
        $price = (float)($product['price'] ?? 0);
        $lineTotal = $price * (int)$quantity;
        $cartTotal += $lineTotal;
        $cartItems[] = [
            'id' => $id,
            'name' => $product['name'] ?? 'Produit',
            'price' => $price,
            'image' => $product['image'] ?? '',
            'quantity' => (int)$quantity,
            'line_total' => $lineTotal
        ];
    }
}

require __DIR__ . '/../Views/cart.php';
