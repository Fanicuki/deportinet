<?php
include('../../db.php');

if (isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];
    $fecha_aceptacion = date('Y-m-d H:i:s');

    // Actualizar el estado del pedido y la fecha de aceptación
    $query = "UPDATE pedidos 
              SET estado = 'Completado', fecha_aceptacion = '$fecha_aceptacion' 
              WHERE id_pedido = $id_pedido";

    if (mysqli_query($conn, $query)) {
        header('Location: pedidos-jefe.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
