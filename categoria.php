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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container" style="padding-top: 150px">
  <h2 class="mb-4">Categoría: <?= htmlspecialchars($nombre_categoria) ?></h2>

  <?php if (!empty($publicaciones)): ?>
    <?php foreach ($publicaciones as $index => $post): ?>
      <div class="row align-items-center mb-5">
        <?php if ($index % 2 == 0): ?>
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
  <?php else: ?>
    <p>No hay publicaciones en esta categoría.</p>
  <?php endif; ?>
</div>

</body>
</html>