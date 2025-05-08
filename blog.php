<?php
session_start();

// Conexión a la base de datos
function conectarBaseDatos() {
    $host = "localhost";
    $db   = "login";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
         $pdo = new PDO($dsn, $user, $pass, $options);
         return $pdo;
    } catch (PDOException $e) {
         die("Error de conexión: " . $e->getMessage());
    }
}

// Obtener publicaciones
function obtenerPublicaciones() {
    $bd = conectarBaseDatos();
    $sentencia = "SELECT * FROM publicaciones ORDER BY fecha_publicacion DESC";
    $consulta = $bd->query($sentencia);
    return $consulta->fetchAll();
}

$publicaciones = obtenerPublicaciones();
?>




<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Dipssy</title>

  <!-- Estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet" />
  <!--<link href="css/cartas.css" rel="stylesheet" />-->
  <!--<link href="css/estructurablog.css" rel="stylesheet" />-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


  <!-- Ajuste de altura para la barra azul 
  <script>
    function ajustarAlturaBarra() {
      const img = document.getElementById('tituloimg');
      const barra = document.getElementById('barracolor');
      if (img && barra) {
        barra.style.height = img.offsetHeight + 'px';
      }
    }
    window.addEventListener('load', ajustarAlturaBarra);
    window.addEventListener('resize', ajustarAlturaBarra);
  </script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
-->


</head>

<body>
  
  <header>
  <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">

  <div class="container-fluid">

    <!-- Logo -->
    <a class="navbar-brand" href="#">
      <img src="img/Dipsyy.png" alt="Logo" style="max-height: 60px;" />
    </a>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido del navbar -->
    <div class="collapse navbar-collapse" id="navbarContent">

      <!-- Enlaces de navegación -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2"><a class="nav-link" href="index.php" id="homel">Inicio</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="index_about.php" id="aboutl">Acerca De</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="blog.php" id="blogl">Blog</a></li>
        <li class="nav-item dropdown mx-2">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" id="languagel">Español</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">English</a></li>
          </ul>
        </li>
      </ul>

      <!-- Búsqueda y Login -->
      <div class="d-flex align-items-center ms-lg-auto flex-column flex-lg-row gap-2">

        <!-- Formulario de búsqueda -->
        <form class="form">
          <label for="search">
            <input class="input" type="text" required placeholder="Busca en el blog..." id="search">
            <div class="fancy-bg"></div>
            <div class="search">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <g>
                  <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                </g>
              </svg>
            </div>
            <button class="close-btn" type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
          </label>
        </form>

        <!-- Botón de login -->
         <div class="logg">
        <a href="login_usuarios.php" class="d-flex align-items-center text-white text-decoration-none">
          <i class="bi bi-person fs-5 me-1"></i>
          <span class="d-none d-sm-inline" id="loginn">Iniciar Sesión</span>
        </a>





  </div>

      </div>
    </div>
  </div>
</nav>


    
    <div class="navbar-categories">
      <ul class="nav justify-content-center">
        <li class="nav-item"><a class="nav-link categoria-link" href="#">ECOSISTEMAS</a></li>
        <li class="nav-item"><a class="nav-link categoria-link" href="#">CONTAMINACION</a></li>
        <li class="nav-item"><a class="nav-link categoria-link" href="#">PESCA</a></li>
        <li class="nav-item"><a class="nav-link categoria-link" href="#">EDUCAR</a></li>
      </ul>
    </div>
  </header>


  


  
        
    <div class="container" style="padding-top: 150px">
    <?php foreach ($publicaciones as $index => $post): ?>
        <div class="row align-items-center mb-5">
            <?php if ($index % 2 == 0): ?>
                <!-- Imagen a la izquierda -->
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($post->imagen_portada) ?>" class="img-fluid rounded shadow" alt="Imagen de portada">
                </div>
                <div class="col-md-8">
                    <h3><?= htmlspecialchars($post->titulo) ?></h3>
                    <p class="text-muted">Por <?= htmlspecialchars($post->autor_nombre) ?> - <?= htmlspecialchars($post->fecha_publicacion) ?></p>
                    <p><?= nl2br(htmlspecialchars($post->resumen)) ?></p>
                    <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
                </div>
            <?php else: ?>
                <!-- Imagen a la derecha -->
                <div class="col-md-8">
                    <h3><?= htmlspecialchars($post->titulo) ?></h3>
                    <p class="text-muted">Por <?= htmlspecialchars($post->autor_nombre) ?> - <?= htmlspecialchars($post->fecha_publicacion) ?></p>
                    <p><?= nl2br(htmlspecialchars($post->resumen)) ?></p>
                    <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
                </div>
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($post->imagen_portada) ?>" class="img-fluid rounded shadow" alt="Imagen de portada">
                </div>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>