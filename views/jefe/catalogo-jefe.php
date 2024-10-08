<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeportiNet - Catálogo</title>
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

    if (isset($_SESSION['cart'])) {
        // Verifica si el producto está en el carrito y lo elimina
        $key = array_search($remove_product_id, $_SESSION['cart']);
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindexar el array
        }
    }

    // Redirigir a la misma página del carrito para evitar reenvío del formulario
    header("Location: carrito.php");
    exit();
}
?>
    <!-- Navbar -->
    <div class="navbar">
        <a class="navbar-brand" href="index-jefe.php">
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
        <form id="form" role="search" action="buscar.php" method="GET" class="searchbar">
            <input type="search" id="query" name="q" placeholder="Buscar..." aria-label="Search through site content" required>
            <button type="submit">
                <svg width="30" height="30" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 19a8.5 8.5 0 1 0 0-17 8.5 8.5 0 0 0 0 17Z"></path>
                    <path d="M13.328 7.172A3.988 3.988 0 0 0 10.5 6a3.988 3.988 0 0 0-2.828 1.172"></path>
                    <path d="m16.61 16.611 4.244 4.243"></path>
                </svg>
            </button>
        </form>
        <div class="navbar-icons">
            <?php echo $_SESSION['usuario']; ?>
            <!-- Dropdown de perfil -->
            <div class="dropdown" style="display: inline">
                <a class="profile " href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg width="46" height="46" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
                        <path d="M21 22a9 9 0 1 0-18 0"></path>
                    </svg>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="top: 40px; left: -90px;">
                    <li><a class="dropdown-item" href="../../logeo.php" style="margin-left: 0;text-align: center;">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index-jefe.php"><svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 21V9L2 11l10-8 10 8-2.5-2v12h-15Z"></path>
            <path d="M9.5 14.5V21h5v-6.5h-5Z"></path>
            <path d="M4.5 21h15"></path>
          </svg>Inicio</a>
        <a href="catalogo-jefe.php">
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.5 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M4.5 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M4.5 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M10.5 12h11"></path>
                <path d="M10.5 19h11"></path>
                <path d="M10.5 5h11"></path>
              </svg>Catálogo</a>
        <a href="pedidos-jefe.php">
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2a10 10 0 1 0 0 20 10 10 0 1 0 0-20z"></path>
            <path d="M12 6v6l4 2"></path>
            </svg>
            Pedidos</a>
        <div class="diagonal-block block1"></div>
        <div class="diagonal-block block2"></div>
        <div class="diagonal-block block3"></div>
    </div>

    <!-- Contenedor Principal -->
    <div class="main-content">
        <div class="sub-content">
            <div class="sub-navbar">
                <p>Catálogo</p>
                <a href="#"><button type="button" style="background-color: transparent; border-color: transparent; float: right" onclick="openModal()">
                <p style="font-size: 20px;">Añadir producto</p>
                <svg width="30" height="30" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 12c0-4.969-4.031-9-9-9s-9 4.031-9 9 4.031 9 9 9 9-4.031 9-9Z"></path>
                    <path d="M12 8.25v7.5"></path>
                    <path d="M15.75 12h-7.5"></path>
                </svg>
            </button></a>

            <div id="addProductModal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <form id="addProductForm" method="POST" action="añadir_producto.php">
                        <label for="nombre">Nombre del producto:</label>
                        <input type="text" id="nombre" name="nombre" required>
                        
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" required></textarea>
                        
                        <label for="precio">Precio:</label>
                        <input type="number" id="precio" name="precio" step="0.01" required>
                        
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" required>
                        

                        <label for="id_categoria">Categoría:</label>
                        <select id="id_categoria" name="id_categoria" required>
                            <option value="1">Pelotas</option>
                            <option value="2">Indumentaria deportiva</option>
                            <option value="3">Calzado Deportivo</option>
                        </select>

                        <button type="submit" style="display: flex; margin-top: 15px;">Añadir Producto</button>
                    </form>
                </div>
            </div>

            </div>
            <div class="list-sub-navbar">
                <p>Producto</p>
                <p>Descripción</p>
                <p>Precio</p>
                <p>Categoría</p>
            </div>
        </div>
        
        <!-- Contenido adicional -->
        <div class="contenido">
            <?php
                include '../../db.php';
                // back-end
                $query = "SELECT Productos.*, Categorias.nombre_categoria FROM Productos JOIN Categorias ON Productos.id_categoria = Categorias.id_categoria";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='producto'>";
                        echo "<h3>" . $row['nombre'] . "</h3>";
                        echo "<p>" . $row['descripcion'] . "</p>";
                        echo "<p>$" . $row['precio'] . "</p>";
                        echo "<p>" . $row['nombre_categoria'] . "</p>";
                        echo "<form class='add-cart' method='POST' action='carrito.php'>";
                        echo "<input type='hidden' name='product_id' value='" . $row['id_producto'] . "'>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "No hay productos disponibles";
                }
            ?>
    </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function updateCartCount() {
            fetch('obtener_cantidad_carrito.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('cart-count').textContent = data;
                });
        }

        // Actualiza el contador cada 5 segundos
        setInterval(updateCartCount, 5000);

        // Actualiza el contador cuando se carga la página
        window.onload = updateCartCount;
    </script>
    <script>
        function openModal() {
            document.getElementById("addProductModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("addProductModal").style.display = "none";
        }

    </script>
</body>
<style>
    #addProductModal {
    position: fixed;
    z-index: 3;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.4);
    display: none; /* Ocultar inicialmente */
    animation: slideDown 0.4s ease-out; /* Animación de desplazamiento */
}

@keyframes slideDown {
    from {
        top: -100%;
        opacity: 0;
    }
    to {
        top: 0;
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        top: 0;
        opacity: 1;
    }
    to {
        top: -100%;
        opacity: 0;
    }
}

.modal-content {
    background-color: #333; /* Fondo oscuro para resaltar el texto blanco */
    color: white; /* Texto blanco */
    padding: 20px;
    border-radius: 15px;
    width: 80%;
    max-width: 500px;
    margin: 250px auto; /* Centrado vertical y horizontal */
    position: relative;
}


.modal-content input[type="text"],
.modal-content input[type="number"],
.modal-content textarea {
    width: 95%; /* Asegura que los inputs tomen todo el ancho disponible */
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    background-color: #444;
    color: white;
}

.modal-content textarea {
    resize: none;
    max-width: 100%;
    height: 100px; /* Limite de altura para el input de descripción */
}

.close {
    color: white;
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

#addProductModal.close-modal {
    animation: slideUp 0.4s ease-out forwards; /* Animación al cerrar */
}

body.modal-content {
    overflow: hidden;
}

</style>
</html>
