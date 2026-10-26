<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/catalogo_ui.php';

[$q, $cat] = deportinet_request_filters();

$opts = [
    'root' => '',
    'title' => 'DeportiNet - Catálogo',
    'page' => 'catalog',
    'auth' => 'guest',
    'active' => 'catalogo',
    'home_href' => 'index.php',
    'catalog_href' => 'catalogo.php',
    'search_action' => 'catalogo.php',
    'login_href' => 'logeo.php',
    'logout_href' => 'logeo.php',
    'q' => $q,
    'cat' => $cat,
];

$categories = deportinet_categorias($conn);
$products = deportinet_productos($conn);

deportinet_open($opts);
deportinet_render_catalog($opts, $products, $categories);
deportinet_close($opts);
