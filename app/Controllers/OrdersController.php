<?php
if (empty($_SESSION['user'])) {
    header('Location: /signin');
    exit;
}

require __DIR__ . '/../Models/Order.php';

$title = "Mes commandes";
$orders = Order::listForUser($pdo, $_SESSION['user']);

require __DIR__ . '/../Views/orders.php';
