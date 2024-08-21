<?php
// Incluye el archivo de conexión a la base de datos
include 'db.php';

// Inicializa la variable de mensaje
$mensaje = "";

// Verifica si el método de solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] === 'register') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Prepara la consulta SQL para verificar si el nombre de usuario ya existe
    $sql = "SELECT id FROM Usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $mensaje = "El usuario ya existe.";
    } else {
        // Si el nombre de usuario no existe, inserta el nuevo usuario en la base de datos
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuarios (gmail, usuario, contraseña) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $usuario, $contraseña_encriptada);
        if ($stmt->execute()) {
            // Redirige al formulario de inicio de sesión con un mensaje de éxito
            header("Location: logeo.php?mensaje=Usuario creado con éxito. Por favor, inicie sesión.");
            exit();
        } else {
            $mensaje = "Error al registrar el usuario. Inténtelo de nuevo.";
        }
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./cssMain/logeo.css">
</head>
<body>
    <div class="contenedor">
        <div class="logo-container">
            <svg width="65" height="65" fill="none" stroke="crimson" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths aquí -->
            </svg>
            DeportiNet
        </div>
        <div class="main">
            <div class="login">
                <form action="logeo.php" method="post">
                    <label for="chk" aria-hidden="true">Iniciar Sesión</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
            <div class="signup">
                <form action="register.php" method="post">
                    <label for="chk" aria-hidden="true">Crear Usuario</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Gmail" required>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <button type="submit" name="accion" value="register">Registrarse</button>
                    <?php if ($mensaje): ?>
                        <div class="mensaje"><?php echo $mensaje; ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
