<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catalogo-cliente.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;
if ($cantidad < 1) {
    $cantidad = 1;
}
if ($cantidad > 99) {
    $cantidad = 99;
}

if ($product_id <= 0) {
    header('Location: catalogo-cliente.php');
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product_exists = false;
foreach ($_SESSION['cart'] as &$item) {
    if (is_array($item) && (int) ($item['id'] ?? 0) === $product_id) {
        $item['cantidad'] = (int) $item['cantidad'] + $cantidad;
        $product_exists = true;
        break;
    }
}
unset($item);

if (!$product_exists) {
    $_SESSION['cart'][] = [
        'id' => $product_id,
        'cantidad' => $cantidad,
    ];
}

$_SESSION['flash'] = 'Producto agregado al carrito.';
$_SESSION['flash_type'] = 'ok';
header('Location: catalogo-cliente.php');
exit;
