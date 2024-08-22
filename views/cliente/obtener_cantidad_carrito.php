<?php
// archivo: obtener_cantidad_carrito.php
session_start();

$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
}

echo $cart_count;
?>
