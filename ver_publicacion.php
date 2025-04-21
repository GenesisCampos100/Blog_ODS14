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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/publicacion.css">
    <title><?= htmlspecialchars($post->titulo) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
    <h1><?= htmlspecialchars($post->titulo) ?></h1>
    <p class="text-muted">
        Por <?= htmlspecialchars($post->autor_nombre) ?> - <?= htmlspecialchars($post->fecha_publicacion) ?><br>
        Categoría: <strong><?= htmlspecialchars($post->categoria) ?></strong>
    </p>
    
    
    <?php foreach ($elementos as $el): ?>
        <?php if ($el->tipo === 'texto'): ?>
            <?= $el->contenido ?>
            <?php elseif ($el->tipo === 'imagen'): ?>
    <div class="imagen-publicacion">
        <img src="<?= htmlspecialchars($el->contenido) ?>" alt="Imagen de la publicación">
    </div>
<?php endif; ?>
    <?php endforeach; ?>

    
    <?php if (!empty($post->referencias)): ?> 
<!-- Si el campo de referencias no está vacío, entonces se muestra el bloque -->

    <div class="mt-4">
        <h5>Referencias</h5>
        <ul>
        <?php 
        $lineas = explode("\n", $post->referencias); 
        // Separa las referencias por cada salto de línea, creando un array

        foreach ($lineas as $ref): 
            $ref = trim($ref); 
            // Quita espacios en blanco al inicio y al final de cada línea

            if (!empty($ref)): 
                // Solo si la línea no está vacía

                if (filter_var($ref, FILTER_VALIDATE_URL)) {
                    // Si la línea es una URL válida...

                    $host = parse_url($ref, PHP_URL_HOST);
                    // Obtiene el dominio del enlace (por ejemplo: www.ejemplo.com)

                    $nombreSitio = ucfirst(str_replace('www.', '', $host));
                    // Elimina el "www." si existe y pone la primera letra en mayúscula

                    echo "<li>$nombreSitio. (s.f.). Recuperado de <a href=\"$ref\" target=\"_blank\">$ref</a></li>";
                    // Muestra la referencia con formato APA básico para sitios web

                } else {
                    echo "<li>" . htmlspecialchars($ref) . "</li>";
                    // Si no es un enlace, se imprime tal cual el texto de la referencia, protegido con htmlspecialchars
                }
            endif;
        endforeach;
        ?>
        </ul>
    </div>

<?php endif; ?>
<!-- Fin del bloque si hay referencias -->



    <a href="blog.php" class="btn btn-secondary mt-3">Volver al Blog</a>
    </div>

</body>
</html>
