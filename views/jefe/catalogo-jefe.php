<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../includes/catalogo_ui.php';

[$q, $cat] = deportinet_request_filters();
$categories = deportinet_categorias($conn);

$opts = [
    'root' => '../../',
    'title' => 'DeportiNet - Catálogo',
    'page' => 'catalog',
    'auth' => 'jefe',
    'active' => 'catalogo',
    'home_href' => 'index-jefe.php',
    'catalog_href' => 'catalogo-jefe.php',
    'orders_href' => 'pedidos-jefe.php',
    'search_action' => 'catalogo-jefe.php',
    'login_href' => '../../logeo.php',
    'logout_href' => '../../logeo.php',
    'usuario' => $_SESSION['usuario'] ?? '',
    'q' => $q,
    'cat' => $cat,
    'admin_modal' => true,
    'categories' => $categories,
];

$products = deportinet_productos($conn);

deportinet_open($opts);
deportinet_render_catalog($opts, $products, $categories);
deportinet_close($opts);
