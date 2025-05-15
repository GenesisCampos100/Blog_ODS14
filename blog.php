
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
      $sentencia = "
  SELECT publicaciones.*, categorias.nombre AS categoria_nombre
  FROM publicaciones
  JOIN categorias ON publicaciones.categoria_id = categorias.id
  ORDER BY publicaciones.fecha_publicacion DESC
";

      $consulta = $bd->query($sentencia);
      return $consulta->fetchAll();
  }

  $publicaciones = obtenerPublicaciones();

  $primerasCinco = array_slice($publicaciones, 0, 6);
$restoPublicaciones = array_slice($publicaciones, 6);

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
  <link href="css/Blogs.css" rel="stylesheet" />
  <link href="css/cartas.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>



  <script>
    var myCarousel = document.querySelector('#myCarousel')
var carousel = new bootstrap.Carousel(myCarousel)

  </script>

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
</nav>

</header>

<?php
$primeras_por_categoria = [];
foreach ($publicaciones as $post) {
    if (!isset($primeras_por_categoria[$post->categoria_nombre])) {
        $primeras_por_categoria[$post->categoria_nombre] = $post;
    }
}
?>




<div id="ods14Carousel" class="carousel slide" data-bs-ride="carousel" style="margin-top: 110px">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="img/11.jpg" class="d-block w-100" alt="Coral">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Protección de los ecosistemas marinos</h5>
        <p> La ODS 14 busca conservar y utilizar sosteniblemente los océanos, mares y recursos marinos.</p>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="img/22.jpg" class="d-block w-100" alt="Contaminación Marina">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Reducción de la contaminación marina</h5>
        <p>Se busca reducir la contaminación por plásticos y otros desechos que dañan la vida submarina.</p>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="img/33.jpg" class="d-block w-100" alt="Pesca sostenible">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Pesca sostenible</h5>
        <p>Una gestión responsable de la pesca es esencial para preservar las especies marinas.</p>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="carousel-item">
      <img src="img/44.jpg" class="d-block w-100" alt="Biodiversidad marina">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Preservación de la biodiversidad marina</h5>
        <p>La vida submarina es clave para el equilibrio del planeta y necesita ser protegida.</p>
      </div>
    </div>

  </div>

  <!-- Controles -->
  <button class="carousel-control-prev" type="button" data-bs-target="#ods14Carousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#ods14Carousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>


<div class="titulopubli" style="margin-top: 60px">
  <!--<img src="img/5.jpg" class="imgt">-->
  <div class="titulopublii"> Últimas publicaciones...</div>
</div>
  
<!-- Publicaciones recientes -->
<div class="publicacionescaja" style="margin-top:20px">
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($primerasCinco as $post): ?>
      <div class="publicacion_car">
        <div class="card h-100">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" class="imagen_tarjeta" alt="Imagen de portada">
          <div class="contenido_tarjeta">
            <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>">
              <div class="categoria_tarjetaa"><?= htmlspecialchars($post->categoria_nombre) ?></div>
    </a>
            <h5 class="titulo_tarjeta"><?= htmlspecialchars($post->titulo) ?></h5>
            <p class="card-text text-muted"><?= nl2br(htmlspecialchars($post->resumen)) ?></p>
            <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>



<section class="tarjetascat" style="margin-top:40px">
  
  <div class="row text-center">
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body" style="padding:10px">
          <a href="categoria.php?id=2">
          <i class="fas fa-water iconotarjeta"></i>
          <h5 class="card-title">Ecosistemas</h5>
          <p class="card-text">Conservación de ecosistemas marinos y costeros para un futuro sostenible.</p>
    </a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body" style="padding:10px">
          <a href="categoria.php?id=1">
          <i class="fas fa-recycle iconotarjeta"></i>
          <h5 class="card-title">Contaminación Marina</h5>
          <p class="card-text">Reducir los desechos marinos, especialmente el plástico.</p>
    </a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body" style="padding:10px">
          <a href="categoria.php?id=3">
          <i class="fas fa-fish iconotarjeta"></i>
          <h5 class="card-title">Pesca Sostenible</h5>
          <p class="card-text">Fomentar la pesca responsable y regulada para preservar recursos.</p>
    </a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body" style="padding:10px">
          <a href="categoria.php?id=4">
          <i class="fas fa-book-open iconotarjeta"></i>
          <h5 class="card-title">Educación Oceánica</h5>
          <p class="card-text">Promover la conciencia sobre la importancia de los océanos.</p>
    </a>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="titulopubli">
  <!--<img src="img/5.jpg" class="imgt">-->
  <div class="titulopublii"> Descubre más...</div>
</div>
<!-- Otras publicaciones -->
<div class="publicacionescaja">
  <?php foreach ($restoPublicaciones as $index => $post): ?>
    <div class="publicacion">
      <?php if ($index % 2 == 0): ?>
        <div class="coverimg">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen de portada">
          <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>">
            <div class="categoriap"><?= htmlspecialchars($post->categoria_nombre) ?></div>
      </a>
        </div>
        <div class="texto">
          <div class="titulop"><?= htmlspecialchars($post->titulo) ?></div>
          <div class="autorp"><?= htmlspecialchars($post->autor_nombre) ?></div>
          <div class="resumen"><?= nl2br(htmlspecialchars($post->resumen)) ?></div>
          <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
        </div>
      <?php else: ?>
        <div class="texto">
          <div class="titulop"><?= htmlspecialchars($post->titulo) ?></div>
          <div class="autorp"><?= htmlspecialchars($post->autor_nombre) ?></div>
          <div class="resumen"><?= nl2br(htmlspecialchars($post->resumen)) ?></div>
          <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
        </div>
        <div class="coverimg">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen de portada">
          <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>">
            <div class="categoriap"><?= htmlspecialchars($post->categoria_nombre) ?></div>
      </a>
        </div>
      <?php endif; ?>
    </div>
    <hr>
  <?php endforeach; ?>
</div>





<section class="sumate">
  <h1>¡Súmate al cambio!</h1>
  <p>Participa en nuestras campañas, comparte información y actúa.</p>
  <a href="index_about.php" class="btn btn-light">Más sobre nosotors</a>
</section>

<footer class="footer">
  <div class="footer-container">
    <!-- Columna 1: Información y logo -->
    <div class="footer-col">
      <img src="img/logooo.png" alt="Logo" class="footer-logo">
      <p><i class="fas fa-envelope"></i> Dipsy@dipsy.com</p>
      <p><i class="fas fa-map-marker-alt"></i> Carretera Manzanillo-Cihuatlán kilómetro 20, El Naranjo, 28860 Manzanillo, Col.</p>
    </div>

    <!-- Columna 2: Enlaces -->
    <div class="footer-col">
      <h4 id="enlaces">ENLACES</h4>
      <ul>
        <li><a id="iniciofo"href="index.php">Inicio</a></li>
        <li><a id="nosotrosfo" href="index_about.php">Acerca De</a></li>
        <li><a id="blogfo"href="#">Blog</a></li>
        <li><a id="contactofo" href="#">Contacto</a></li>
      </ul>
    </div>

    <!-- Columna 3: Redes Sociales -->
    <div class="footer-col">
      <h4 id="redessocial">REDES SOCIALES</h4>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <!-- Columna 4: Newsletter -->
    <div class="footer-col">
      <h4 id="contacto">CONTACTANOS</h4>
      <form class="newsletter">
      <input type="email" placeholder="Email">
        <input type="text" placeholder="Mensaje">
        <button id="correo"type="submit">ENVIAR</button>
      </form>
    </div>
  </div>
  <div class="footer-bottom">
    <p>©Dipsy 2025</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body> 
</html>



  