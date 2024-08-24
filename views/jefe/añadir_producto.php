<?php
include '../../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "INSERT INTO Productos (nombre, descripcion, precio, stock, id_categoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id_categoria);

    if ($stmt->execute()) {
        echo "Producto añadido exitosamente.";
    } else {
        echo "Error al añadir el producto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
