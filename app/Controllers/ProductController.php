<?php
require __DIR__ . '/../Models/Product.php';

$productId = isset($_GET['id']) ? (int) $_GET['id'] : null;

if ($productId) {
    $product = Product::find($pdo, $productId);
    if (!$product) {
        http_response_code(404);
        echo "Produit introuvable";
        exit;
    }
    $title = $product["name"] ?? "Produit";
    require __DIR__ . '/../Views/product.php';
    exit;
}

$catSlug = $_GET['cat'] ?? null;
$catId = Product::categoryIdFromSlug($catSlug);

if ($catSlug && $catId === null) {
    http_response_code(404);
    echo "Catégorie inconnue";
    exit;
}

$title = $catSlug ? ("Produits — " . strtoupper($catSlug)) : "Produits";

if ($catId !== null) {
    $products = Product::byCategory($pdo, $catId);
} else {
    $products = Product::all($pdo);
}

require __DIR__ . '/../Views/products.php';
