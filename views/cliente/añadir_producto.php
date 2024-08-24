<?php
session_start();

// Si se envía un formulario para añadir un producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verifica si el producto ya está en el carrito
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['cantidad'] += $cantidad;
            $product_exists = true;
            break;
        }
    }

    // Si el producto no está en el carrito, añadirlo
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'cantidad' => $cantidad
        ];
    }

    // Redirigir a la misma página del catálogo para evitar reenvío del formulario
    header("Location: catalogo-cliente.php");
    exit();
}

?>
