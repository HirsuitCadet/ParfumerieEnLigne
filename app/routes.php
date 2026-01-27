<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri !== '/' && str_ends_with($uri, '/')) {
    $uri = rtrim($uri, '/');
}

switch ($uri) {
    case '/':
        require __DIR__ . '/Controllers/HomeController.php';
        break;

    case '/products':
    case '/product':
        require __DIR__ . '/Controllers/ProductController.php';
        break;

    case '/cart':
        require __DIR__ . '/Controllers/CartController.php';
        break;

    case '/order':
        require __DIR__ . '/Controllers/OrderController.php';
        break;

    case '/about':
        require __DIR__ . '/Views/about.php';
        break;

    case '/contact':
        require __DIR__ . '/Views/contact.php';
        break;

    case '/privacy':
        require __DIR__ . '/Views/privacy.php';
        break;

    case '/cookies':
        require __DIR__ . '/Views/cookies.php';
        break;

    case '/cgv':
        require __DIR__ . '/Views/cgv.php';
        break;

    default:
        http_response_code(404);
        echo "404";
}
