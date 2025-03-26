<?php
session_start();
if (!isset($_GET['id'])) {
    die("Publicación no encontrada.");
}

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

// Obtener publicación por ID
function obtenerPublicacion($id) {
    $bd = conectarBaseDatos();
    $sentencia = $bd->prepare("SELECT * FROM publicaciones WHERE id = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetch();
}

$post = obtenerPublicacion($_GET['id']);
if (!$post) {
    die("Publicación no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post->titulo) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h1><?= htmlspecialchars($post->titulo) ?></h1>
        <p class="text-muted">Por <?= htmlspecialchars($post->autor_nombre) ?> - <?= htmlspecialchars($post->fecha_publicacion) ?></p>
        <p><?= nl2br(htmlspecialchars($post->contenido)) ?></p>
        <a href="blog.php" class="btn btn-secondary">Volver al Blog</a>
    </div>

</body>
</html>
