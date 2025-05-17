
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet" />
  <link href="css/Blogs.css" rel="stylesheet" />
  <link href="css/cartas.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>



  <script>
    var myCarousel = document.querySelector('#myCarousel')
var carousel = new bootstrap.Carousel(myCarousel)

  </script>
<!-- AOS Animations -->


<script>
document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById('graficoOds14');
  if (ctx) {
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Contaminación Plástica', 'Pesca Insostenible', 'Cambio Climático', 'Industria'],
        datasets: [{
          data: [35, 25, 30, 10],
          backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#6c757d'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' },
          title: {
            display: true,
            text: 'Amenazas al ecosistema marino'
          }
        }
      }
    });
  } else {
    console.error("Canvas con id 'graficoOds14' no encontrado.");
  }
});
</script>




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
                    <!-- Formulario de búsqueda -->
<form class="form" method="GET" action="busqueda.php">
  <label for="search">
    <input class="input" type="search" name="search" required placeholder="Busca en el blog..." id="search">
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
        <p>La ODS 14 promueve la conservación de hábitats marinos como los arrecifes de coral, vitales para millones de especies y comunidades costeras.</p>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="img/22.jpg" class="d-block w-100" alt="Contaminación Marina">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Reducción de la contaminación marina</h5>
        <p>Se busca frenar el vertido de plásticos, petróleo y otros contaminantes que destruyen la vida marina y afectan la salud humana.</p>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="img/33.jpg" class="d-block w-100" alt="Pesca sostenible">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Pesca sostenible</h5>
        <p>La ODS 14 aboga por técnicas de pesca que respeten los ciclos naturales y eviten la sobreexplotación de las especies.</p>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="carousel-item">
      <img src="img/44.jpg" class="d-block w-100" alt="Biodiversidad marina">
      <div class="carousel-caption d-block bg-dark bg-opacity-50 rounded">
        <h5>Preservación de la biodiversidad marina</h5>
        <p>Los océanos albergan una enorme diversidad de especies. Protegerlos es esencial para el equilibrio ecológico global.</p>
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


<div class="titulopubli" style="margin-top: 40px">
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

<!-- Sección con estadísticas -->
<section class="estadisticas-ods14 py-5" id="estadisticas-ods14" style="margin-top:50px; margin-bottom:50px">
  <div class="container">
    <h2 class="text-center mb-4 text-ods" data-aos="fade-down">Estadísticas clave del ODS 14</h2>
    <p class="text-center mb-5" data-aos="fade-up" style="font-family:'Questrial'; font-size:25px; color: #00ddff;">Datos que reflejan la urgencia de conservar nuestros mares y océanos.</p>

    <div class="row align-items-center">
      <!-- Gráfico a la izquierda -->
      <div class="col-lg-6 mb-4" data-aos="fade-right">
        <canvas id="graficoOds14" style="color:white"></canvas>
      </div>

      <!-- Tarjetas a la derecha -->
      <div class="col-lg-6">
        <div class="row g-4">
          <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
              <i class="bi bi-recycle icono"></i>
              <h4>11 millones</h4>
              <p class="text-muted">de toneladas de plástico entran al océano anualmente.</p>
            </div>
          </div>
          <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card">
              <i class="bi bi-droplet-half icono text-info"></i>
              <h4>40%</h4>
              <p class="text-muted">de los océanos están gravemente afectados por la actividad humana.</p>
            </div>
          </div>
          <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
              <i class="bi bi-exclamation-triangle-fill icono text-warning"></i>

              <h4>1 de cada 3</h4>
              <p class="text-muted">especies de peces están sobreexplotadas.</p>
            </div>
          </div>
          <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card">
              <i class="bi bi-globe2 icono text-warning"></i>
              <h4>90%</h4>
              <p class="text-muted">del calor del cambio climático es absorbido por los océanos.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoOds14').getContext('2d');
new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Contaminación Plástica', 'Pesca Insostenible', 'Cambio Climático', 'Industria'],
    datasets: [{
      data: [35, 25, 30, 10],
      backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#6c757d'],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'bottom' },
      title: {
        display: true,
        text: 'Amenazas al ecosistema marino'
      }
    }
  }
});
</script>


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
        <a href="https://www.facebook.com/profile.php?id=61576567344359"><i class="fab fa-facebook-f"></i></a>
        <a href="https://x.com/DipsyBlog?t=sr9bvN7EyopDopxJWOQtmA&s=09"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.instagram.com/dipsy.blog/"><i class="fab fa-instagram"></i></a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000, once: true });
  </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body> 
</html>



  