<?php
include '../../db.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: carrito.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['productos']) || !is_array($_POST['productos'])) {
        echo "No se han enviado productos.";
        exit;
    }

    $productos = $_POST['productos']; 
    $total = 0;

    // Verifica que la lista de productos no esté vacía
    if (empty($productos)) {
        echo "El carrito está vacío.";
        exit;
    }

    $conn->begin_transaction();
    try {
        // Insertar el pedido
        $stmt = $conn->prepare("INSERT INTO Pedidos (id_usuario, estado, total) VALUES (?, 'En proceso', ?)");
        $stmt->bind_param("id", $id_usuario, $total);
        $stmt->execute();
        $id_pedido = $conn->insert_id;

        // Insertar los detalles del pedido
        foreach ($productos as $producto) {
            if (!isset($producto['id'], $producto['cantidad'], $producto['precio'])) {
                throw new Exception("Datos de producto incompletos.");
            }

            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];
            $total += $precio * $cantidad;

            $stmt = $conn->prepare("INSERT INTO DetallePedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio);
            $stmt->execute();
        }

        // Actualizar el total
        $stmt = $conn->prepare("UPDATE Pedidos SET total = ? WHERE id_pedido = ?");
        $stmt->bind_param("di", $total, $id_pedido);
        $stmt->execute();

        // Eliminar productos del carrito del usuario
        unset($_SESSION['cart']); // Suponiendo que guardas el carrito en la sesión

        $conn->commit();
        echo "Pedido creado";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
