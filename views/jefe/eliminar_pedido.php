<?php
include '../../db.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: logeo.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = $_POST['id_pedido'];

    if (!empty($id_pedido)) {
        $conn->begin_transaction();
        try {
            // Eliminar detalles del pedido
            $stmt = $conn->prepare("DELETE FROM DetallePedido WHERE id_pedido = ?");
            $stmt->bind_param("i", $id_pedido);
            $stmt->execute();

            // Eliminar el pedido
            $stmt = $conn->prepare("DELETE FROM Pedidos WHERE id_pedido = ?");
            $stmt->bind_param("i", $id_pedido);
            $stmt->execute();

            $conn->commit();
            header("Location: pedidos-jefe.php"); // Redirigir después de eliminar
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
