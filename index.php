<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeportiNet - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index-main.css">
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
        <form id="form" role="search">
            <input type="search" id="query" name="q"
             placeholder="Buscar..."
             aria-label="Search through site content">
            <button>
                <svg width="30" height="30" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <!-- SVG paths -->
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
                <p>Menú</p>
            </div>
        </div>
        <div class="carousel-container">
            <!-- Carrusel Bootstrap -->
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://preview.thenewsmarket.com/Previews/ADID/StillAssets/1920x1080/555469_v5.JPG"  alt="Imagen 1">
                    </div>
                    <div class="carousel-item">
                        <img src="https://assets.goal.com/images/v3/bltbc19a765112b199e/77d64118f93aec9c3bbe7a8066e975c3a84d5a35.jpg"  alt="Imagen 2">
                    </div>
                    <div class="carousel-item">
                        <img src="https://preview.thenewsmarket.com/Previews/ADID/StillAssets/1920x1080/643339_v2.jpg"  alt="Imagen 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Contenido adicional -->
        <div>
            <h2>HOLAAAA MAS GRANDEEE</h2>
            <p>HOLAAAAAAA</p>
        </div>
    </div>
    <?php
include 'db.php';

$query = "SELECT Productos.*, Categorias.nombre_categoria FROM Productos JOIN Categorias ON Productos.id_categoria = Categorias.id_categoria";
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
    echo "No hay productos disponibles.";
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWDSHjMxoBrJzkNCtfgZre2FZ2Jt23V+HoK1R9Y7sl1Pq4DuhzHpuY3CkThM6f57" crossorigin="anonymous"></script>
    <script>
        const f = document.getElementById('form');
        const q = document.getElementById('query');
        const google = '';
        const site = 'pagedart.com';
  
        function submitted(event) {
          event.preventDefault();
          const url = google + site + '+' + q.value;
          const win = window.open(url, '_blank');
          win.focus();
        }
  
        f.addEventListener('submit', submitted);
    </script>
    <script>
        // Inicialización del carrusel
        const carousel = new bootstrap.Carousel('#carouselExample', {
            interval: 3000, // Cambia de imagen cada 3 segundos
            pause: 'hover' // Pausa el carrusel al pasar el mouse sobre él
        });
    </script>
</body>
</html>