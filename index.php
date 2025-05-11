<?php
session_start();

function conectarBaseDatos() {
    $host = "localhost";
    $db   = "login";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function obtenerUltimaPublicacion() {
    $bd = conectarBaseDatos();
    $sql = "SELECT p.*, c.nombre AS categoria 
            FROM publicaciones p 
            JOIN categorias c ON p.categoria_id = c.id 
            ORDER BY fecha_publicacion DESC 
            LIMIT 1";
    $stmt = $bd->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
}

function obtenerElementosPublicacion($id_publicacion) {
    $bd = conectarBaseDatos();
    $sql = "SELECT tipo, contenido FROM publicacion_elementos WHERE publicacion_id = ? ORDER BY orden ASC";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$id_publicacion]);
    return $stmt->fetchAll();
}

// Obtener publicación más reciente
$post = obtenerUltimaPublicacion();
$elementos = $post ? obtenerElementosPublicacion($post->id) : [];

function obtenerPublicacionesRecientes($limite = 5, $offset = 1) {
  $bd = conectarBaseDatos();
  $sql = "SELECT p.*, c.nombre AS categoria 
          FROM publicaciones p 
          JOIN categorias c ON p.categoria_id = c.id 
          ORDER BY fecha_publicacion DESC 
          LIMIT ? OFFSET ?";
  $stmt = $bd->prepare($sql);
  $stmt->bindValue(1, (int)$limite, PDO::PARAM_INT);
  $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll();
}

$tarjetas = obtenerPublicacionesRecientes();

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
  
  <link href="css/estructurablog.css" rel="stylesheet"/>
  <link href="css/cartas.css" rel="stylesheet" />
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>



  <!-- Ajuste de altura para la barra azul -->
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

<script crossorigin="anonymous"></script>


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


  <div id="barracolor" class="barracolor"></div>

  <?php if ($post): ?>
<div class="publicacionhome">

  <div class="imagenportada">
  <img id="tituloimg" class="imgtituloblog img-fluid" src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen Portada">

    </div>

  <div class="categoriass">
      <div class="categoria"><?= htmlspecialchars($post->categoria) ?></div>
    </div>


  <div class="titulopublicacion">
    <?= htmlspecialchars($post->titulo) ?>
  </div>


  <div class="resumenpublicacion">
    <?= htmlspecialchars($post->resumen) ?>
  </div>

  <div class="autor">
      <div class="autor-info">
        <div class="autorr"><?= htmlspecialchars($post->autor_nombre) ?></div>
        <?php $fecha = new DateTime($post->fecha_publicacion); ?>
<div class="fecha"><?= $fecha->format('d/m/Y') ?></div>
      </div>
      <div class="comentariolink">COMENTARIOS</div>
    </div>



    <?php foreach ($elementos as $el): ?>
        <?php if ($el->tipo === 'texto'): ?>
          <div class="textoblog">
            <?= $el->contenido ?>
        </div>
        <?php elseif ($el->tipo === 'imagen'): ?>
            <div class="imagen-publicacion">
                <img src="<?= htmlspecialchars($el->contenido) ?>" alt="Imagen de la publicación" class="img-fluid">
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    

    <?php if (!empty($post->referencias)): ?>

      <div class="referencias">
      <div class="tituloref">Referencias</div>
      <div class="referenciass">
      <ul>
                <?php 
                $lineas = explode("\n", $post->referencias); 
                foreach ($lineas as $ref): 
                    $ref = trim($ref);
                    if (!empty($ref)):
                        if (filter_var($ref, FILTER_VALIDATE_URL)) {
                            $host = parse_url($ref, PHP_URL_HOST);
                            $nombreSitio = ucfirst(str_replace('www.', '', $host));
                            echo "<li>$nombreSitio. (s.f.). Recuperado de <a href=\"$ref\" target=\"_blank\">$ref</a></li>";
                        } else {
                            echo "<li>" . htmlspecialchars($ref) . "</li>";
                        }
                    endif;
                endforeach;
                ?>
            </ul>
      </div>
    </div>

    
<!-- From Uiverse.io by JesusRafaelNavaCruz --> 
<div class="publicacionesrecientes">

<div class="titulopublicaciones">Publicaciones Recientes</div>

  <?php foreach ($tarjetas as $tarjeta): ?>
    <div class="publicacion_tarjeta">
      <img src="<?= htmlspecialchars($tarjeta->imagen_portada) ?>" alt="Imagen de portada" class="imagen_tarjeta">
      <div class="categoria_tarjeta"><?= htmlspecialchars($tarjeta->categoria) ?></div>
      <div class="contenido_tarjeta">
        <p class="titulo_tarjeta"><?= htmlspecialchars($tarjeta->titulo) ?></p>
        <p class="resumen_tarjeta"><?= htmlspecialchars($tarjeta->resumen) ?></p>
        <a href="ver_publicacion.php?id=<?= htmlspecialchars($tarjeta->id) ?>" class="btn btn-primary" id="leer">Leer más</a>
      </div>

    </div>
  <?php endforeach; ?>
</div>

        <?php endif; ?>

<?php else: ?>
<div class="container mt-5">
    <p>No hay publicaciones aún.</p>
</div>
<?php endif; ?>
</div>

 
<footer class="footerd">

  <img class="logo_footer" src="img/Logooo.png"  alt="Logo">


<!--
<div class="Eslogan">
“Explora, comprende y protege: el océano es vida, y su futuro depende de lo que hagamos hoy.”
</div>
-->


<!--
<div class="link-barra">
    <a href="index.php">Inicio</a>
    <span>|</span>
    <a href="index_about.php">Acerca De</a>
    <span>|</span>
    <a href="blog.php">Blog</a>
</div>
-->

  <!-- From Uiverse.io by vinodjangid07 --> 
<!-- From Uiverse.io by javierBarroso --> 
<div class="social-login-icons">
  <div class="socialcontainer">
    <div class="icon social-icon-1-1">
      <svg
        viewBox="0 0 512 512"
        height="1.7em"
        xmlns="http://www.w3.org/2000/svg"
        class="svgIcontwit"
        fill="white"
      >
        <path
          d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"
        ></path>
      </svg>
    </div>
    <div class="social-icon-1">
      <svg
        viewBox="0 0 512 512"
        height="1.7em"
        xmlns="http://www.w3.org/2000/svg"
        class="svgIcontwit"
        fill="white"
      >
        <path
          d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"
        ></path>
      </svg>
    </div>
  </div>
  <div class="socialcontainer">
    <div class="icon social-icon-2-2">
      <svg
        fill="white"
        class="svgIcon"
        viewBox="0 0 448 512"
        height="1.5em"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
        ></path>
      </svg>
    </div>
    <div class="social-icon-2">
      <svg
        fill="white"
        class="svgIcon"
        viewBox="0 0 448 512"
        height="1.5em"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
        ></path>
      </svg>
    </div>
  </div>
  <div class="socialcontainer">
    <div class="icon social-icon-3-3">
      <svg
        viewBox="0 0 384 512"
        fill="white"
        height="1.6em"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"
        ></path>
      </svg>
    </div>
    <div class="social-icon-3">
      <svg
        viewBox="0 0 384 512"
        fill="white"
        height="1.6em"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"
        ></path>
      </svg>
    </div>
  </div>
  <div class="socialcontainer">
    <div class="icon social-icon-4-4">
      <svg fill="white" viewBox="0 0 496 512" height="1.6em">
        <path
          d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"
        ></path>
      </svg>
    </div>
    <div class="social-icon-4">
      <svg fill="white" viewBox="0 0 496 512" height="1.6em">
        <path
          d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"
        ></path>
      </svg>
    </div>
  </div>
</div>
          
</footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>