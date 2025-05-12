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

// Obtener publicación por ID con categoría
function obtenerPublicacion($id) {
    $bd = conectarBaseDatos();
    $sentencia = $bd->prepare("
        SELECT p.*, c.nombre AS categoria 
        FROM publicaciones p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE p.id = ?
    ");
    $sentencia->execute([$id]);
    return $sentencia->fetch();
}

function obtenerElementosPublicacion($id_publicacion) {
    $bd = conectarBaseDatos();
    $sql = "SELECT tipo, contenido FROM publicacion_elementos WHERE publicacion_id = ? ORDER BY orden ASC";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$id_publicacion]);
    return $stmt->fetchAll();
}


$post = obtenerPublicacion($_GET['id']);
$elementos = obtenerElementosPublicacion($_GET['id']);

if (!$post) {
    die("Publicación no encontrada.");
}

// Obtener comentarios de una publicación
function obtenerComentarios($publicacion_id) {
    $bd = conectarBaseDatos();
    $sql = "SELECT c.*, u.nombre AS autor 
            FROM comentarios c 
            JOIN usuarios u ON c.usuario_id = u.id 
            WHERE c.publicacion_id = ? 
            ORDER BY c.fecha_comentario DESC";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$publicacion_id]);
    return $stmt->fetchAll();
}

// Registrar un nuevo comentario
function agregarComentario($publicacion_id, $usuario_id, $contenido) {
    $bd = conectarBaseDatos();
    $sql = "INSERT INTO comentarios (publicacion_id, usuario_id, contenido) VALUES (?, ?, ?)";
    $stmt = $bd->prepare($sql);
    return $stmt->execute([$publicacion_id, $usuario_id, $contenido]);
}




?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Dipssy</title>

  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (para dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


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
  <?php
// Si aún no hay URL guardada y no estamos en login
if (!isset($_SESSION['redirect_url']) && basename($_SERVER['PHP_SELF']) !== 'login_usuarios.php') {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Página actual
}
?>

  <?php if (isset($_SESSION['usuario_nombre'])): ?>
    
  <div class="dropdown">
    <a class="usuario-logeado d-flex align-items-center text-white dropdown-toggle text-decoration-none" href="" id="dropdownUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-person-circle fs-5 me-2"></i>
      <span class="d-none d-sm-inline"><?= htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUsuario">
      <li>
        <a class="dropdown-item text-danger" href="logout.php" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?');">
          <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
        </a>
      </li>
    </ul>
  </div>
<?php else: ?>
   <div class="logg">
            <a href="login_usuarios.php" class="d-flex align-items-center text-white text-decoration-none">
              <i class="bi bi-person fs-5 me-1"></i>
              <span class="d-none d-sm-inline" id="loginn">Iniciar Sesión</span>
            </a>
          </div>
<?php endif; ?>

 

        </div>
      </div>
    </div>
  

  <!-- Categorías -->
   
  <div class="navbar-categories">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Conservacion de Ecosistemas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Contaminación Marina</a>
      </li>
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Pesca Sostenible</a>
      </li>
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Educacion Oceanica</a>
      </li>
    </ul>
  </div>
  <nav>

</header>




<div id="barracolor" class="barracolor"></div>

<div class="publicacionhome">

    <div class="imagenportada">
        <img id="tituloimg" class="imgtituloblog" src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen Portada" class="img-fluid">
    </div>

    <div class="categoriass">
      <div class="categoria"><?= htmlspecialchars($post->categoria) ?></div>
    </div>

    <div class="titulopublicacion"><?= htmlspecialchars($post->titulo) ?></div>


    <div class="resumenpublicacion">
    <?= htmlspecialchars($post->resumen) ?>
    </div>
    
    <div class="autor">
      <div class="autor-info">
        <div class="autorr"><?= htmlspecialchars($post->autor_nombre) ?></div>
        <div class="fecha"><?= htmlspecialchars($post->fecha_publicacion) ?></div>
      </div>

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
 <?php endif; ?>
<!-- Fin del bloque si hay referencias -->

      <!-- Sección de comentarios -->
<div class="comentarios">
    <h3>Comentarios</h3>

    
</div>

</div>

    </div>
    </div>

   


    <a href="blog.php" class="btn btn-secondary mt-3">Volver al Blog</a>
    </div>

</body>
</html>