<script>

</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<div class="container-fluid">

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <svg width="46" height="46" fill="none" stroke="orange" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
            <div class="navbar-icons">
            <a class="shopping-cart" type="button" href="#"><svg width="30" height="30" fill="none" stroke="orange" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 20a1 1 0 1 0 0 2 1 1 0 1 0 0-2z"></path>
                <path d="M20 20a1 1 0 1 0 0 2 1 1 0 1 0 0-2z"></path>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg></a>
            <a class="profile" type="button" href="login.svelte">
                Iniciar Sesión
            </a>
          
            </div>
        </div>
    </nav>
    <div class="sidebar">
        <a href="#home">Inicio</a>
        <a href="#tutorials">Catalogo</a>
    </div>
    <div class="content">
        <div>
            
        </div>
    </div>
</div>
<style>

.container-fluid {
    --bs-gutter-x: 0rem;
}

.bg-body-tertiary {
    background-color: #3165d4 !important;
}

.navbar-icons {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    align-items: center;
}

.profile {
    margin-right: 20px;
    text-decoration: none;
    color: #fff;
}

.navbar-brand {
    color: #fff !important;
    margin-left: 20px;
}

.content {
    position: fixed;
    left: 200px;
    width: 100%;
    height: 100%;
}

.content {
    background-color: #ffffff;
}

.sidebar {
    width: 200px;
    height: 100%;
    background-color: #3165d4e0;
    color: #fff;
    box-sizing: border-box;
    position: fixed;
    font-size: 20px;
}
.sidebar a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 10px;
}

.sidebar a:hover {
    background-color: orange;
}
</style>