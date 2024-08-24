<?php
session_start(); // Iniciar la sesión
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT id, gmail, contraseña, rol FROM Usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $gmail, $contraseña_encriptada, $rol);
        $stmt->fetch();
        if (password_verify($contraseña, $contraseña_encriptada)) {
            // Almacenar los datos del usuario en la sesión
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['gmail'] = $gmail;
            $_SESSION['rol'] = $rol;

            // Redirigir al usuario según su rol
            if ($rol === 'cliente') {
                header("Location: ./views/cliente/index-cliente.php");
            } elseif ($rol === 'admin') {
                header("Location: ./views/jefe/index-jefe.php");
            } else {
                echo "Rol no reconocido.";
            }
            exit();
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
}

$conn->close();
?>
