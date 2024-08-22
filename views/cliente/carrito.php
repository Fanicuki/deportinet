<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeportiNet - Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index-main.css">
</head>

<body>
<?php
session_start();
include '../../db.php';

// Procesar eliminación de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $remove_product_id = $_POST['remove_product_id'];

    // Verifica si el producto está en el carrito y lo elimina
    if (($key = array_search($remove_product_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindexar el array
    }

    // Redirigir a la misma página del carrito para evitar reenvío del formulario
    header("Location: carrito.php");
    exit();
}

?>
<?php
session_start();

// Si se envía un formulario para añadir un producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Aquí puedes añadir la lógica para buscar los detalles del producto en tu base de datos
    // y añadirlo al carrito. En este ejemplo, solo estamos almacenando el ID del producto.

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Añadir el producto al carrito
    $_SESSION['cart'][] = $product_id;

    // Redirigir a la misma página del carrito para evitar reenvío del formulario
    header("Location: carrito.php");
    exit();
}
?>

    <!-- Navbar -->
    <div class="navbar">
        <a class="navbar-brand" href="index-cliente.php">
            <svg width="46" height="46" fill="none" stroke="crimson" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 12a9.969 9.969 0 0 1-2.944 7.087A9.968 9.968 0 0 1 12 22C6.477 22 2 17.523 2 12a9.966 9.966 0 0 1 2.75-6.888A9.972 9.972 0 0 1 12 2a9.969 9.969 0 0 1 7.056 2.913A9.97 9.97 0 0 1 22 12Z"></path>
                <path d="M22 12c-1.459 0-5.484-.55-9.087 1.031C9 14.75 6.166 17.416 4.932 19.073"></path>
                <path d="M8.25 2.727C9.815 4.17 13.23 7.849 14.5 11.5c1.27 3.65 1.74 8.14 2.03 9.417"></path>
                <path d="M2.077 10.75c1.889.114 6.89.217 10.09-1.15 3.2-1.366 5.953-3.88 6.897-4.677"></path>
                <path d="M2.75 15.807a10.038 10.038 0 0 0 4.5 4.995"></path>
                <path d="M2 12a9.966 9.966 0 0 1 2.75-6.888"></path>
                <path d="M12 2a9.972 9.972 0 0 0-7.25 3.112"></path>
                <path d="M16 2.832a10.02 10.02 0 0 1 3.056 2.081A9.97 9.97 0 0 1 22 12a9.98 9.98 0 0 1-.63 3.5"></path>
                <path d="M12 22a9.968 9.968 0 0 0 7.056-2.913"></path>
            </svg>
            DeportiNet
        </a>
        <form id="form" role="search">
            <input type="search" id="query" name="q"
             placeholder="Buscar..."
             aria-label="Search through site content">
            <button><svg width="30" height="30" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.5 19a8.5 8.5 0 1 0 0-17 8.5 8.5 0 0 0 0 17Z"></path>
                <path d="M13.328 7.172A3.988 3.988 0 0 0 10.5 6a3.988 3.988 0 0 0-2.828 1.172"></path>
                <path d="m16.61 16.611 4.244 4.243"></path>
              </svg></button>
          </form>
          <div class="navbar-icons">
            <a class="shopping-cart" type="button" href="./carrito.php"><svg width="30" height="30" fill="none" stroke="crimson" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 20a1 1 0 1 0 0 2 1 1 0 1 0 0-2z"></path>
                    <path d="M20 20a1 1 0 1 0 0 2 1 1 0 1 0 0-2z"></path>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg></a>
            <a class="profile" type="button" href="#">
            <svg width="46" height="46" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
                <path d="M21 22a9 9 0 1 0-18 0"></path>
                </svg>
            </a>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index-cliente.php"><svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 21V9L2 11l10-8 10 8-2.5-2v12h-15Z"></path>
            <path d="M9.5 14.5V21h5v-6.5h-5Z"></path>
            <path d="M4.5 21h15"></path>
          </svg>Inicio</a>
        <a href="catalogo-cliente.php">
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.5 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M4.5 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M4.5 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M10.5 12h11"></path>
                <path d="M10.5 19h11"></path>
                <path d="M10.5 5h11"></path>
              </svg>Catálogo</a>
    </div>

    <!-- Contenedor Principal -->
    <div class="main-content">
        <div class="sub-content">
            <div class="sub-navbar">
                <p>Carrito</p>
            </div>

        <!-- Contenido adicional -->
        <div>
        <?php
            if (!empty($_SESSION['cart'])) {
                $ids = implode(',', array_map('intval', $_SESSION['cart']));
                $query = "SELECT Productos.*, Categorias.nombre_categoria FROM Productos 
                        JOIN Categorias ON Productos.id_categoria = Categorias.id_categoria 
                        WHERE Productos.id_producto IN ($ids)";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    echo '<ul class="contenido">';
                    while ($row = $result->fetch_assoc()) {
                        echo "<li class='producto'>Nombre: " . $row['nombre'] . "<br> 
                            Precio: $" . $row['precio'] . "<br> 
                            Categoría: " . $row['nombre_categoria'] . "<br>";

                        // Botón para eliminar el producto
                        echo "<form method='POST' action='carrito.php' class='delete-btn'>
                                <input type='hidden' name='remove_product_id' value='" . $row['id_producto'] . "'>
                                <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                                </form>";

                        echo "</li>";
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="non-product">No se encontraron productos en el carrito.</p>';
                }
            } else {
                echo '<p class="non-product">Tu carrito está vacío.</p>';
            }
        ?>

        </div>
    </div>

</body>

</html>
