<?php
include 'db.php';

$id_pedido = $_POST['id_pedido'];

$query = "UPDATE Pedidos SET estado = 'Preparado' WHERE id_pedido = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pedido);

if ($stmt->execute()) {
    echo "Pedido preparado.";
} else {
    echo "Error de pedido.";
}
?>