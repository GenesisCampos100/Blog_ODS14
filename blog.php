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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Home Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Dipsy</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index_about.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="blog.php">Blog</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Category
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Category 1</a></li>
                  <li><a class="dropdown-item" href="#">Category 2</a>
                  </li>
              </li>
              </ul>
              <li class="nav-item">
               
              </li>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
        
      <div class="container mt-4">
        <div class="row">
            <?php foreach ($publicaciones as $post) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($post->titulo) ?></h3>
                            <p class="text-muted">Por <?= htmlspecialchars($post->autor_nombre) ?> - <?= htmlspecialchars($post->fecha_publicacion) ?></p>
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars(substr($post->contenido, 0, 150))) ?>...
                            </p>
                            <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>