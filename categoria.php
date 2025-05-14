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
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Obtener publicaciones por categoría
function obtenerPublicacionesPorCategoria($categoria_id) {
    $bd = conectarBaseDatos();
    $stmt = $bd->prepare("SELECT * FROM publicaciones WHERE categoria_id = ? ORDER BY fecha_publicacion DESC");
    $stmt->execute([$categoria_id]);
    return $stmt->fetchAll();
}

// Obtener nombre de la categoría
function obtenerNombreCategoria($categoria_id) {
    $bd = conectarBaseDatos();
    $stmt = $bd->prepare("SELECT nombre FROM categorias WHERE id = ?");
    $stmt->execute([$categoria_id]);
    $row = $stmt->fetch();
    return $row ? $row->nombre : null;
}

// Obtener ID desde la URL
$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$publicaciones = obtenerPublicacionesPorCategoria($categoria_id);
$nombre_categoria = obtenerNombreCategoria($categoria_id);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Publicaciones - <?= htmlspecialchars($nombre_categoria) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/Blogs.css" rel="stylesheet">
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">

      <!-- Logo -->
      <a class="navbar-brand" href="#">
        <img src="img/Logoo.png" alt="Logo" style="max-height: 60px;" />
      </a>

      <!-- Botón hamburguesa -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Contenido del navbar -->
      <div class="collapse navbar-collapse" id="navbarContent">

        <!-- Enlaces de navegación -->
        <ul class="navbar-nav">
          <li class="nav-item mx-2">
            <a class="nav-link" href="index.php" id="homel">Inicio</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="index_about.php" id="aboutl">Acerca De</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="blog.php" id="blogl">Blog</a>
          </li>
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
  

  <!-- Categorías -->
   
  <div class="navbar-categories">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <!-- Usa ID o nombre -->
        <a class="nav-link categoria-link" href="categoria.php?id=2">Conservación de Ecosistemas</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" href="categoria.php?id=1">Contaminación Marina</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" href="categoria.php?id=3">Pesca Sostenible</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" href="categoria.php?id=4">Educación Oceánica</a>
      </li>
    </ul>
  </div>
  <nav>

</header>


<div class="publicacionescaja" style="margin-top:150px">
  <?php foreach ($publicaciones as $index => $post): ?>
    <div class="publicacion">
      <?php if ($index % 2 == 0): ?>
        <!-- Imagen a la izquierda -->
        <div class="coverimg">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen de portada">
          <div class="categoriap"><?= htmlspecialchars($nombre_categoria) ?></div>
        </div>
        
        <div class="texto">
          <div class="titulop"><?= htmlspecialchars($post->titulo) ?></div>
          <div class="autorp"><?= htmlspecialchars($post->autor_nombre) ?></div>
          <div class="resumen"><?= nl2br(htmlspecialchars($post->resumen)) ?></div>
          <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
        </div>
      <?php else: ?>
        <!-- Imagen a la derecha -->
        <div class="texto">
          <div class="titulop"><?= htmlspecialchars($post->titulo) ?></div>
          <div class="autorp"><?= htmlspecialchars($post->autor_nombre) ?></div>
          <div class="resumen"><?= nl2br(htmlspecialchars($post->resumen)) ?></div>
          <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
        </div>

        <div class="coverimg">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen de portada">
          <div class="categoriap"><?= htmlspecialchars($nombre_categoria) ?></div>
        </div>
      <?php endif; ?>
    </div>
    <hr>
  <?php endforeach; ?>
</div>

</body>
</html>
