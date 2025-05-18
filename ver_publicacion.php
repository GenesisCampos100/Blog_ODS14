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


function obtenerPublicacionesAleatorias($id_actual, $limite = 5) {
    $bd = conectarBaseDatos();
    $sql = "
        SELECT p.*, c.nombre AS categoria 
        FROM publicaciones p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id != ?
        ORDER BY RAND()
        LIMIT ?
    ";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$id_actual, $limite]);
    return $stmt->fetchAll();
}

// Obtener 5 publicaciones aleatorias
$recomendadas = obtenerPublicacionesAleatorias($_GET['id']);


//require_once 'db.php'; // Conexión

// Validar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido");
}
$id_publicacion = intval($_GET['id']);

// Función para insertar comentario
function agregarComentario($publicacion_id, $usuario_id, $contenido) {
    $bd = conectarBaseDatos();
    $sql = "INSERT INTO comentarios (publicacion_id, usuario_id, contenido) VALUES (?, ?, ?)";
    $stmt = $bd->prepare($sql);
    return $stmt->execute([$publicacion_id, $usuario_id, $contenido]);
}

// Función para obtener comentarios como objetos
function obtenerComentarios($publicacion_id) {
    $bd = conectarBaseDatos();
    $sql = "SELECT c.*, u.nombre AS autor 
            FROM comentarios c 
            JOIN usuarios u ON c.usuario_id = u.id 
            WHERE c.publicacion_id = ? 
            ORDER BY c.fecha_comentario DESC";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$publicacion_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

// Procesar comentario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_comentar'])) {
    if (isset($_SESSION['idUsuario']) && !empty($_POST['comentario'])) {
        $usuario_id = $_SESSION['idUsuario'];
        $contenido = trim($_POST['comentario']);

        if (!empty($contenido)) {
            if (agregarComentario($id_publicacion, $usuario_id, $contenido)) {
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                $_SESSION['error_comentario'] = "Hubo un error al guardar tu comentario.";
            }
        } else {
            $_SESSION['error_comentario'] = "El comentario no puede estar vacío.";
        }
    } else {
        $_SESSION['error_comentario'] = "Debes iniciar sesión para comentar.";
    }

    // Redirigir para evitar reenvío del formulario
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

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

  <script>
  // Mostrar el botón cuando el usuario baja
  window.onscroll = function () {
    const btn = document.getElementById("scrollTopBtn");
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
      btn.style.display = "block";
    } else {
      btn.style.display = "none";
    }
  };

  // Función para volver al inicio
  function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>


<script crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const boton = document.getElementById("toggleComentarios");
    const icono = document.getElementById("iconoComentarios");
    const texto = boton.querySelector("span");
    const collapse = document.getElementById("seccionComentarios");

    collapse.addEventListener('shown.bs.collapse', function () {
        texto.textContent = "Ocultar comentarios";
        icono.className = "bi bi-eye-slash";
    });

    collapse.addEventListener('hidden.bs.collapse', function () {
        texto.textContent = "Ver comentarios";
        icono.className = "bi bi-eye";
    });
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
          <!-- Ícono de idioma alineado -->
        <li class="nav-item mx-2 dropdown">
          <button id="botonIdioma" class="btn nav-link p-0 border-0 bg-transparent" 
                  data-bs-toggle="dropdown" aria-expanded="false">
            <img id="banderaIdioma" src="img/espana.png" alt="Idioma" style="height: 20px;">
          </button>
          <ul class="dropdown-menu" aria-labelledby="botonIdioma">
                      <!-- Por esto -->
          <li><a class="dropdown-item" href="#" onclick="cambiarIdioma('es','en')">Inglés</a></li>
          <li><a class="dropdown-item" href="#" onclick="cambiarIdioma('en','es')">Español</a></li>
         </ul>
        </li>
        </ul>

        <!-- Búsqueda y Login -->
        <div class="d-flex align-items-center ms-lg-auto flex-column flex-lg-row gap-2">

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
        <!-- Usa ID o nombre -->
        <a class="nav-link categoria-link" id="navCategoria1" href="categoria.php?id=2">Conservación de Ecosistemas</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" id="navCategoria2" href="categoria.php?id=1">Contaminación Marina</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" id="navCategoria3" href="categoria.php?id=3">Pesca Sostenible</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" id="navCategoria4" href="categoria.php?id=4">Educación Oceánica</a>
      </li>
    </ul>
  </div>
  </nav>

</header>

<!--
<button onclick="window.history.back()" 
  class="btn rounded-0 position-absolute d-none d-md-block"
  style="top: 140px; width: fit-content; height: fit-content; z-index: 998;">
  <i class="bi bi-arrow-left text-white fs-1"></i>
</button>
-->





<div id="barracolor" class="barracolor"></div>

<div class="publicacionhome">
    <div class="imagenportada">
        <img id="tituloimg" class="imgtituloblog" src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen Portada" class="img-fluid">
    </div>

    <div class="categoriass">
        <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>" class="categoria-link">
            <div class="categoria"><?= htmlspecialchars($post->categoria) ?></div>
        </a>
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
       <a href="#comentariosss" class="comentariolink">COMENTARIOS</a>
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
            <div id="tituloReferencias" class="tituloref">Referencias</div>
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

        <div class="publicacionesrecientes">
            <div id="tituloPublicacionesRecomendadas" class="titulopublicaciones">Publicaciones Recomendadas</div>
            <?php foreach ($recomendadas as $tarjeta): ?>
                <div class="publicacion_tarjeta">
                    <img src="<?= htmlspecialchars($tarjeta->imagen_portada) ?>" alt="Imagen de portada" class="imagen_tarjeta">
                    <a href="categoria.php?id=<?= urlencode($tarjeta->categoria_id) ?>" class="categoria-link">
                        <div class="categoria_tarjeta"><?= htmlspecialchars($tarjeta->categoria) ?></div>
                    </a>
                    <div class="contenido_tarjeta">
                        <p class="titulo_tarjeta"><?= htmlspecialchars($tarjeta->titulo) ?></p>
                        <p class="resumen_tarjeta"><?= htmlspecialchars($tarjeta->resumen) ?></p>
                        <a href="ver_publicacion.php?id=<?= htmlspecialchars($tarjeta->id) ?>" class="btn btn-primary" id="leer">Leer más</a>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
    <?php endif; ?>



   <div class="text-center" style="margin-top:50px" id="comentariosss">
  <button class="btn btn-outline-primary mb-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#seccionComentarios" aria-expanded="false" aria-controls="seccionComentarios" id="toggleComentarios">
    <i class="bi bi-eye" id="iconoComentarios"></i>
    <span>Ver comentarios</span>
</button>
</div>
</div>


<!-- Contenedor de comentarios colapsable -->
<div class="collapse" id="seccionComentarios">
        <div class="comentarios">
            <div id="tituloComentarios" class="titulopublicaciones">Comentarios</div>

            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <form action="" method="POST">
                    <div class="comment-input">
                        <textarea name="comentario" class="form-control" rows="3" placeholder="Escribe tu comentario..." required></textarea>
                    </div>
                    <button type="submit" name="btn_comentar" class="btn btn-primary">Comentar</button>
                </form>
            <?php else: ?>
                <p class="text-muted" style="margin-top:60px">Debes <a href="login_usuarios.php">iniciar sesión</a> para comentar.</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_comentario'])): ?>
                <p class="text-danger"><?= $_SESSION['error_comentario'] ?></p>
                <?php unset($_SESSION['error_comentario']); ?>
            <?php endif; ?>

            <div class="lista-comentarios">
                <?php
                $comentarios = obtenerComentarios($id_publicacion);
                if ($comentarios):
                    foreach ($comentarios as $comentario):
                ?>
                    <div class="comentario border-bottom">
                        <strong><?= htmlspecialchars($comentario->autor) ?></strong><br>
                        <p ><?= nl2br(htmlspecialchars($comentario->contenido)) ?></p>
                        <small class="text-muted"><?= $comentario->fecha_comentario ?></small>
                    </div>
                <?php
                    endforeach;
                else:
                    echo "<p class='text-muted'>Aún no hay comentarios.</p>";
                endif;
                ?>
            
        </div>
    </div>
</div>
    


<!-- Botón Volver Arriba -->
<button onclick="scrollToTop()" id="scrollTopBtn"
  class="btn btn-primary position-fixed"
  style="bottom: 20px; right: 80px; display: none; width: 50px; height: 50px; z-index: 900;">
  <i class="bi bi-arrow-up text-white fs-4"></i>
</button>

<script>
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Mostrar/ocultar botón scroll arriba
window.onscroll = function () {
  const scrollBtn = document.getElementById("scrollTopBtn");
  scrollBtn.style.display = window.scrollY > 100 ? "block" : "none";
};

// Actualizar texto e icono del botón de comentarios
const toggleBtn = document.getElementById("toggleComentarios");
const icono = document.getElementById("iconoComentarios");
const texto = toggleBtn.querySelector("span");
const collapse = document.getElementById("seccionComentarios");

collapse.addEventListener('shown.bs.collapse', () => {
  texto.textContent = "Ocultar comentarios";
  icono.className = "bi bi-eye-slash";
});

collapse.addEventListener('hidden.bs.collapse', () => {
  texto.textContent = "Ver comentarios";
  icono.className = "bi bi-eye";
});
</script>



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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="traductor.js"></script>
</body>
</html>