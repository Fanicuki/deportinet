<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['nombre']; // Corrected gmail field name
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (gmail, usuario, contraseña) VALUES (?, ?, ?)"; // Removed extra placeholder
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $gmail, $usuario, $contraseña_encriptada); // Adjusted parameter count

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
