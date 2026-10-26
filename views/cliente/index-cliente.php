<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../includes/catalogo_ui.php';

$cartCount = (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;

$opts = [
    'root' => '../../',
    'title' => 'DeportiNet',
    'page' => 'home',
    'auth' => 'cliente',
    'active' => 'inicio',
    'home_href' => 'index-cliente.php',
    'catalog_href' => 'catalogo-cliente.php',
    'search_action' => 'catalogo-cliente.php',
    'login_href' => '../../logeo.php',
    'logout_href' => '../../logeo.php',
    'cart_href' => 'carrito.php',
    'add_action' => 'añadir_producto.php',
    'usuario' => $_SESSION['usuario'] ?? '',
    'cart_count' => $cartCount,
];

$categories = deportinet_categorias($conn);
$products = deportinet_productos($conn, 4);

deportinet_open($opts);
deportinet_render_home($opts, $products, $categories);
deportinet_close($opts);
