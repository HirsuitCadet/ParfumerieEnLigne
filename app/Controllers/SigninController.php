<?php
if (!empty($_GET['redirect'])) {
    $_SESSION['redirect_after_login'] = $_GET['redirect'];
}
$redirect = $_SESSION['redirect_after_login'] ?? '';
if (!empty($_SESSION['user'])) {
    if ($redirect) {
        header('Location: ' . $redirect);
        exit;
    }
    header('Location: /');
    exit;
}

$errors = [
    'email' => '',
    'password' => ''
];
$old = [
    'email' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $old['email'] = $email;

    if ($email === '') {
        $errors['email'] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    if ($password === '') {
        $errors['password'] = "Le mot de passe est requis.";
    }

    if ($errors['email'] === '' && $errors['password'] === '') {
        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->prepare('SELECT id, firstname, lastname, email, password_hash FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors['email'] = "Email ou mot de passe incorrect.";
            $errors['password'] = "Email ou mot de passe incorrect.";
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email']
            ];
            if (!empty($_SESSION['pending_cart_action'])) {
                $pending = $_SESSION['pending_cart_action'];
                unset($_SESSION['pending_cart_action']);
                require __DIR__ . '/../Models/Product.php';
                $productId = (int)($pending['product_id'] ?? 0);
                $qty = (int)($pending['quantity'] ?? 1);
                $action = $pending['action'] ?? '';
                if ($productId > 0) {
                    $product = Product::find($pdo, $productId);
                    if ($product) {
                        $stock = isset($product['stock']) ? (int)$product['stock'] : null;
                        $maxQty = $stock !== null ? max(0, $stock) : 1;
                        if ($maxQty > 0) {
                            if ($qty < 1) {
                                $qty = 1;
                            }
                            if ($qty > $maxQty) {
                                $qty = $maxQty;
                            }
                            if ($action === 'add') {
                                if (!isset($_SESSION['cart']['items']) || !is_array($_SESSION['cart']['items'])) {
                                    $_SESSION['cart'] = ['items' => []];
                                }
                                $current = (int)($_SESSION['cart']['items'][$productId] ?? 0);
                                $newQty = $current + $qty;
                                if ($newQty > $maxQty) {
                                    $newQty = $maxQty;
                                }
                                $_SESSION['cart']['items'][$productId] = $newQty;
                            } elseif ($action === 'buy') {
                                $_SESSION['checkout_items'] = [
                                    [
                                        'product_id' => $productId,
                                        'quantity' => $qty
                                    ]
                                ];
                            }
                        }
                    }
                }
            }
            if ($redirect) {
                unset($_SESSION['redirect_after_login']);
                header('Location: ' . $redirect);
            } else {
                header('Location: /');
            }
            exit;
        }
    }
}

require __DIR__ . '/../Views/signin.php';
