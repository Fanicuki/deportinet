<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeportiNet - Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./cssMain/index-main.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a class="navbar-brand" href="#">
            <svg width="46" height="46" fill="none" stroke="crimson" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths -->
            </svg>
            DeportiNet
        </a>
        <form id="form" role="search" onsubmit="return searchProducts(event);">
            <input type="search" id="query" name="q" placeholder="Buscar..." aria-label="Search through site content">
            <button type="submit">
                <svg width="30" height="30" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 19a8.5 8.5 0 1 0 0-17 8.5 8.5 0 0 0 0 17Z"></path>
                    <path d="M13.328 7.172A3.988 3.988 0 0 0 10.5 6a3.988 3.988 0 0 0-2.828 1.172"></path>
                    <path d="m16.61 16.611 4.244 4.243"></path>
                </svg>
            </button>
        </form>
        <div class="navbar-icons">
            <a class="shopping-cart" type="button" href="#"><svg width="30" height="30" fill="none" stroke="crimson" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths -->
            </svg></a>
            <a class="profile" type="button" href="logeo.php">
                Iniciar Sesión
            </a>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php">
            <svg width="25" height="25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths -->
            </svg>Inicio</a>
        <a href="catalogo.php">
            <svg width="25" height="25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths -->
            </svg>Catálogo</a>
        <a href="ayuda.php">
            <svg width="25" height="25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths -->
            </svg>Ayuda</a>
    </div>
    <!-- Contenedor Principal -->
    <div class="main-content">
        <div class="sub-content">
            <div class="sub-navbar">
                <p>Catálogo</p>
            </div>
        </div>
        <!-- Contenido adicional -->
        <div class="contenido">
        <?php
            include 'db.php';

            // Obtener el término de búsqueda de la URL si existe
            $searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

            // Modificar la consulta SQL para incluir la búsqueda
            $query = "SELECT Productos.*, Categorias.nombre_categoria 
                      FROM Productos 
                      JOIN Categorias ON Productos.id_categoria = Categorias.id_categoria";

            // Si hay un término de búsqueda, agregar la cláusula WHERE
            if (!empty($searchTerm)) {
                $searchTerm = $conn->real_escape_string($searchTerm); // Escapar el término de búsqueda
                $query .= " WHERE Productos.nombre LIKE '%$searchTerm%'"; // Filtrar por nombre del producto
            }

            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='producto'>";
                    echo "<h3>" . $row['nombre'] . "</h3>";
                    echo "<p>" . $row['descripcion'] . "</p>";
                    echo "<p>Precio: $" . $row['precio'] . "</p>";
                    echo "<p>Categoría: " . $row['nombre_categoria'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "No se encontraron productos que coincidan con tu búsqueda.";
            }
        ?>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function searchProducts(event) {
            event.preventDefault(); // Evita el envío del formulario
            const query = document.getElementById('query').value; // Obtiene el valor de búsqueda
            window.location.href = `catalogo.php?q=${encodeURIComponent(query)}`; // Redirige a la página de catálogo con la consulta
            return false; // Previene el envío del formulario
        }
    </script>
</body>
</html>