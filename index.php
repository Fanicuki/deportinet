
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeportiNet - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./cssMain/index-main.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a class="navbar-brand" href="#">
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
        <form id="form" role="search" action="buscar.php" method="GET">
            <input type="search" id="query" name="q" placeholder="Buscar..." aria-label="Search through site content">
            <button type="submit">
                <svg width="30" height="30" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 19a8.5 8.5 0 1 0 0-17 8.5 8.5 0 0 0 0 17Z"></path>
                    <path d="M13.328 7.172A3.988 3.988 0 0 0 10.5 6a3.988 3.988 0 0 0-2.828 1.172"></path>
                    <path d="m16.61 16.611 4.244 4.243"></path>
                </svg>
            </button>
        </form>
            <a class="profile" type="button" href="logeo.php">
                Iniciar Sesión
            </a>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php" >
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 21V9L2 11l10-8 10 8-2.5-2v12h-15Z"></path>
            <path d="M9.5 14.5V21h5v-6.5h-5Z"></path>
            <path d="M4.5 21h15"></path>
          </svg>Inicio</a>
        <a href="catalogo.php" >
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.5 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M4.5 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M4.5 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                <path d="M10.5 12h11"></path>
                <path d="M10.5 19h11"></path>
                <path d="M10.5 5h11"></path>
              </svg>Catálogo</a>
        <div class="diagonal-block block1"></div>
        <div class="diagonal-block block2"></div>
        <div class="diagonal-block block3"></div>
    </div>
    <!-- Contenedor Principal -->
        <div class="main-content">
            <div class="sub-content">
                <div class="sub-navbar">
                    <p>Menú</p>
                </div>
            </div>
            <div class="content">
                <div class="carousel-container">
                    <!-- Carrusel -->
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://i.pinimg.com/736x/fc/2d/3e/fc2d3e2f6283e20b536dc4864971e272.jpg" alt="Imagen 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://i.pinimg.com/736x/51/f8/43/51f8430fbf1b5d19bacd9d858c38430d.jpg" alt="Imagen 2">
                            </div>
                            <div class="carousel-item">
                                <img src="https://i.pinimg.com/564x/6f/39/0c/6f390c3851bf5d79a66724d5e01167eb.jpg" alt="Imagen 3">
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
                
                <div class="latest-products">
                <h1 style="position: absolute">Últimos productos</h1>
                    <div class="product-list">
                    <?php
                        include 'db.php';
                        // back-end
                        $query = "SELECT Productos.*, Categorias.nombre_categoria 
                                FROM Productos 
                                JOIN Categorias ON Productos.id_categoria = Categorias.id_categoria 
                                ORDER BY Productos.id_producto DESC 
                                LIMIT 5";
                        
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            echo "<div class='productos-container'>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='producto'>";
                                echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
                                echo "<p>" . htmlspecialchars($row['descripcion']) . "</p>";
                                echo "<p class='precio'>$" . htmlspecialchars($row['precio']) . "</p>";
                                echo "<p class='categoria'>" . htmlspecialchars($row['nombre_categoria']) . "</p>";
                                echo "<button class='comprar-btn'>Comprar</button>";
                                echo "</div>";
                            }
                            echo "</div>";
                        } else {
                            echo "No hay productos disponibles";
                        }
                    ?>



                    </div>
                    <div class="categories">
                    <h1>Categorías</h1>
                    <div class="category-buttons">
                        <button class="category-button">
                            <svg width="24" height="24" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3h18v18H3V3Z"></path>
                            </svg>
                            <span>Deportes</span>
                        </button>
                        <button class="category-button">
                            <svg width="24" height="24" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2a10 10 0 0 1 10 10v10H2V12A10 10 0 0 1 12 2Z"></path>
                            </svg>
                            <span>Fitness</span>
                        </button>
                        <button class="category-button">
                            <svg width="24" height="24" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2a10 10 0 0 1 10 10v10H2V12A10 10 0 0 1 12 2Z"></path>
                            </svg>
                            <span>Indumentaria</span>
                        </button>
                    </div>
                </div>
                </div>

                
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
    function searchProducts(event) {
        event.preventDefault();
        const query = document.getElementById('query').value;

        // Realiza la solicitud GET con AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `catalogo.php?q=${query}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Actualiza el contenido del catálogo
                document.getElementById('catalog').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
    </script>

</body>
<style>

.productos-container {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    padding: 20px;
}

.producto {
    display: grid;
    background-color: #f8f8f8;
    border: 2px solid crimson;
    border-radius: 10px;
    padding: 15px;
    width: 250px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.2s;
}

.producto:hover {
    transform: scale(1.05);
}

.producto img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.producto h3 {
    font-size: 18px;
    margin: 10px 0;
    color: #333;
}

.producto p {
    font-size: 14px;
    color: #666;
    margin: 5px 0;
}

.producto .precio {
    font-size: 16px;
    color: #e60000;
    font-weight: bold;
}

.producto .categoria {
    font-size: 12px;
    color: #999;
}

.comprar-btn {
    background-color: crimson;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.comprar-btn:hover {
    background-color: rgb(145, 14, 40);
}

</style>
</html>