//crea, añade, actualiza el pedido
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: logeo.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id']; 
$productos = $_POST['productos']; 
$total = 0;

$conn->begin_transaction();
try {
    $stmt = $conn->prepare("INSERT INTO Pedidos (id_usuario, estado, total) VALUES (?, 'En proceso', ?)");
    $stmt->bind_param("id", $id_usuario, $total);
    $stmt->execute();
    $id_pedido = $conn->insert_id;

    foreach ($productos as $producto) {
        $id_producto = $producto['id'];
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];
        $total += $precio * $cantidad;

        $stmt = $conn->prepare("INSERT INTO DetallePedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio);
        $stmt->execute();
    }

    $stmt = $conn->prepare("UPDATE Pedidos SET total = ? WHERE id_pedido = ?");
    $stmt->bind_param("i", $total, $id_pedido);
    $stmt->execute();

    $conn->commit();
    echo "Pedido creado";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error" . $e->getMessage();
}
?>