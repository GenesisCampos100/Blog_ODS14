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
$id_publicacion = $post ? $post->id : null;
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


// Función para insertar comentario
function agregarComentario($publicacion_id, $usuario_id, $contenido) {
    $bd = conectarBaseDatos();
    $sql = "INSERT INTO comentarios (publicacion_id, usuario_id, contenido) VALUES (?, ?, ?)";
    $stmt = $bd->prepare($sql);
    return $stmt->execute([$publicacion_id, $usuario_id, $contenido]);
}

// Función para obtener comentarios como objetos
function obtenerComentarios($id_publicacion) {
    $bd = conectarBaseDatos();
    $sql = "SELECT c.*, u.nombre AS autor 
            FROM comentarios c 
            JOIN usuarios u ON c.usuario_id = u.id 
            WHERE c.publicacion_id = ? 
            ORDER BY c.fecha_comentario DESC";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$id_publicacion]);
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

<?php include 'navbar.php'; ?>


  <div id="barracolor" class="barracolor"></div>

  <?php if ($post): ?>
<div class="publicacionhome">

  <div class="imagenportada">
  <img id="tituloimg" class="imgtituloblog img-fluid" src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen Portada">

    </div>

  <div class="categoriass">
  <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>" class="categoria-link">
    <div class="categoria"><?= htmlspecialchars($post->categoria) ?></div>
  </a>
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

    <div class="text-center" style="margin-top:50px" id="comentariosss">
  <button class="btn btn-outline-primary mb-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#seccionComentarios" aria-expanded="false" aria-controls="seccionComentarios" id="toggleComentarios">
    <i class="bi bi-eye" id="iconoComentarios"></i>
    <span>Ver comentarios</span>
</button>
</div>


</div>






<!-- Contenedor de comentarios colapsable -->
<div class="collapse" id="seccionComentarios" style="margin-top:0px">
        <div class="comentarios">
            <div class="titulopublicaciones">Comentarios</div>

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


        <?php endif; ?>

<?php else: ?>
<div class="container mt-5">
    <p>No hay publicaciones aún.</p>
</div>
<?php endif; ?>


  



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
</body>
</html>
