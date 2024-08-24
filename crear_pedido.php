<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: logeo.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos'])) {
    $productos = $_POST['productos']; 
    $total = 0;

    // Iniciar la transacción
    $conn->begin_transaction();
    try {
        // Insertar el pedido
        $stmt = $conn->prepare("INSERT INTO Pedidos (id_usuario, estado, total) VALUES (?, 'En proceso', ?)");
        $stmt->bind_param("id", $id_usuario, $total);
        $stmt->execute();
        $id_pedido = $conn->insert_id;

        // Insertar los detalles del pedido
        foreach ($productos as $producto) {
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
        $stmt->bind_param("di", $total, $id_pedido); // Cambio de "i" a "di"
        $stmt->execute();

        // Confirmar la transacción
        $conn->commit();
        echo "Pedido creado";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Datos del pedido no recibidos.";
}
?>
