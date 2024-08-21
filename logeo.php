<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./cssMain/logeo.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<div class="contenedor">
    <div class="logo-container">
        <svg width="65" height="65" fill="none" stroke="crimson" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
    </div>
    <div class="main">
		<!-- FALTA CONFIRMACIÓN DE LOGUEO -->
        <input type="checkbox" id="chk" aria-hidden="true">
            <div class="login">
			    <form action="./views/cliente/index-cliente.php" method="post">
                    <label for="chk" aria-hidden="true">Iniciar Sesión</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <button type="submit" >Entrar</button>
                </form>
            </div>

            <div class="signup">
                <form action="./views/cliente/index-cliente.php" method="post">
                    <label for="chk" aria-hidden="true">Crear Usuario</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Gmail" required>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <button type="submit">Registrarse</button>
                </form>
            </div>
    </div>
</div>