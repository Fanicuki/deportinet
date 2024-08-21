<script>

</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/.css">
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
                <form action="register.php" method="post">
                    <label for="chk" aria-hidden="true">Crear Usuario</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Gmail" required>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <button type="submit">Registrarse</button>
                </form>
            </div>
    </div>
</div>


<style>

.logo-container {
    position: relative;
    color: white;
    font-size: 50px;
    z-index: 1;
	margin-bottom: 40px;
}

body{
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	background-image: url(https://images7.alphacoders.com/344/344223.jpg);
	background-repeat: no-repeat;
	background-size: cover;
}
.main{
	width: 350px;
	height: 500px;
	background: crimson;
	overflow: hidden;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #4d4d4d;
}

#chk{
	display: none;
}
.login{
	position: relative;
	width:100%;
	height: 100%;
}
label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 50px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
	height: 10px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 12px;
	border: none;
	outline: none;
	border-radius: 5px;
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: crimson;
	background: white;
	font-size: 1em;
	font-weight: bold;
	margin-top: 30px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background:dimgrey;
	color: white;
}
.signup{
	height: 460px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.signup label{
	color: crimson;
	transform: scale(.6);
}

#chk:checked ~ .signup{
	transform: translateY(-500px);
}
#chk:checked ~ .signup label{
	transform: scale(1);	
}
#chk:checked ~ .login label{
	transform: scale(.6);
}


</style>