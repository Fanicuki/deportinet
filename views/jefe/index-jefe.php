<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../includes/catalogo_ui.php';

$opts = [
    'root' => '../../',
    'title' => 'DeportiNet',
    'page' => 'home',
    'auth' => 'jefe',
    'active' => 'inicio',
    'home_href' => 'index-jefe.php',
    'catalog_href' => 'catalogo-jefe.php',
    'orders_href' => 'pedidos-jefe.php',
    'search_action' => 'catalogo-jefe.php',
    'login_href' => '../../logeo.php',
    'logout_href' => '../../logeo.php',
    'usuario' => $_SESSION['usuario'] ?? '',
];

$categories = deportinet_categorias($conn);
$products = deportinet_productos($conn, 4);

deportinet_open($opts);
deportinet_render_home($opts, $products, $categories);
deportinet_close($opts);
