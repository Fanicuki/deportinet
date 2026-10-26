<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../includes/catalogo_ui.php';

[$q, $cat] = deportinet_request_filters();
$cartCount = (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;

$opts = [
    'root' => '../../',
    'title' => 'DeportiNet - Catálogo',
    'page' => 'catalog',
    'auth' => 'cliente',
    'active' => 'catalogo',
    'home_href' => 'index-cliente.php',
    'catalog_href' => 'catalogo-cliente.php',
    'search_action' => 'catalogo-cliente.php',
    'login_href' => '../../logeo.php',
    'logout_href' => '../../logeo.php',
    'cart_href' => 'carrito.php',
    'add_action' => 'añadir_producto.php',
    'usuario' => $_SESSION['usuario'] ?? '',
    'cart_count' => $cartCount,
    'q' => $q,
    'cat' => $cat,
];

$categories = deportinet_categorias($conn);
$products = deportinet_productos($conn);

deportinet_open($opts);
deportinet_render_catalog($opts, $products, $categories);
deportinet_close($opts);
