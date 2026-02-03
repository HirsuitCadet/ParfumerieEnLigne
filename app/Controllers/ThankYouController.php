<?php
if (empty($_SESSION['user'])) {
    header('Location: /signin');
    exit;
}

$title = "Merci pour votre commande";
$orderId = $_SESSION['last_order_id'] ?? null;
unset($_SESSION['last_order_id']);

require __DIR__ . '/../Views/thankyou.php';
