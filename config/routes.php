<?php

$routes = [
    '/barang' => '/layouts/barang.php',
    '/bahan-baku' => '/layouts/bahan_baku.php',
];

// URI saat ini
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Mengatur rute
if ($requestUri === '/') {
    header("Location: /barang", true, 302);
    exit();
} elseif (array_key_exists($requestUri, $routes)) {
    require __DIR__ . '/../' . $routes[$requestUri];
}