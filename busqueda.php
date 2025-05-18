<?php
session_start();

// Conexión a la base de datos
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

$busqueda = $_GET['search'] ?? '';
$resultados = [];

if (!empty($busqueda)) {
    $pdo = conectarBaseDatos();
    $sql = "SELECT p.*, c.nombre AS categoria_nombre
        FROM publicaciones p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        WHERE p.titulo LIKE :search1 OR p.contenido LIKE :search2";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'search1' => "%$busqueda%",
        'search2' => "%$busqueda%"
    ]);
    $resultados = $stmt->fetchAll();
}

function resaltarCoincidencia($texto, $busqueda) {
    $busqueda = preg_quote($busqueda, '/'); // Escapar caracteres especiales
    return preg_replace_callback(
        "/($busqueda)/i",
        function ($coincidencia) {
            return '<mark>' . htmlspecialchars($coincidencia[0]) . '</mark>';
        },
        htmlspecialchars($texto)
    );
}


?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet"/>
  <link href="css/Blogs.css" rel="stylesheet"/> 



  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <style>
        h3 {
            color: #022473;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>


<div class="container">
    <h2 class="mb-4 text-white" style="margin-top: 150px;
    font-weight: bold;
    font-size: 30px;
    text-align: center;">Resultados para: <span class="text-info">"<?= htmlspecialchars($busqueda) ?>"</span></h2>

    <?php if ($busqueda === ''): ?>
        <div class="alert alert-info">Por favor, escribe un término de búsqueda.</div>

    <?php elseif (empty($resultados)): ?>
        <div class="alert alert-warning">No se encontraron coincidencias.</div>

    <?php else: ?>
        <<!-- Resultados de búsqueda -->
<div class="publicacionescaja">
  <?php foreach ($resultados as $index => $post): ?>
    <div class="publicacion">
      <?php if ($index % 2 == 0): ?>
        <div class="coverimg">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen de portada">
          <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>">
            <div class="categoriap"><?= htmlspecialchars($post->categoria_nombre ?? 'Sin categoría') ?></div>
          </a>
        </div>
        <div class="texto">
          <div class="titulop"><?= resaltarCoincidencia(htmlspecialchars($post->titulo), $busqueda) ?></div>
          <div class="autorp"><?= htmlspecialchars($post->autor_nombre) ?></div>
          <div class="resumen"><?= resaltarCoincidencia(mb_strimwidth(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($post->resumen)))), 0, 140, '…'), $busqueda) ?></div>
          <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
        </div>
      <?php else: ?>
        <div class="texto">
          <div class="titulop"><?= resaltarCoincidencia(htmlspecialchars($post->titulo), $busqueda) ?></div>
          <div class="autorp"><?= htmlspecialchars($post->autor_nombre) ?></div>
          <div class="resumen"><?= resaltarCoincidencia(mb_strimwidth(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($post->resumen)))), 0, 140, '…'), $busqueda) ?></div>
          <a href="ver_publicacion.php?id=<?= $post->id ?>" class="btn btn-primary">Leer más</a>
        </div>
        <div class="coverimg">
          <img src="<?= htmlspecialchars($post->imagen_portada) ?>" alt="Imagen de portada">
          <a href="categoria.php?id=<?= urlencode($post->categoria_id) ?>">
            <div class="categoriap"><?= htmlspecialchars($post->categoria_nombre ?? 'Sin categoría') ?></div>
          </a>
        </div>
      <?php endif; ?>
    </div>
    <hr>
  <?php endforeach; ?>
</div>

    <?php endif; ?>
</div>



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
