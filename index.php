<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/catalogo_ui.php';

$opts = [
    'root' => '',
    'title' => 'DeportiNet',
    'page' => 'home',
    'auth' => 'guest',
    'active' => 'inicio',
    'home_href' => 'index.php',
    'catalog_href' => 'catalogo.php',
    'search_action' => 'catalogo.php',
    'login_href' => 'logeo.php',
    'logout_href' => 'logeo.php',
];

$categories = deportinet_categorias($conn);
$products = deportinet_productos($conn, 4);

deportinet_open($opts);
deportinet_render_home($opts, $products, $categories);
deportinet_close($opts);
