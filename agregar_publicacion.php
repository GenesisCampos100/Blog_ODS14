<?php
session_start();

// Funciones
function conectarBaseDatos() {
    $host = "localhost";
    $db   = "login";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function obtenerCategorias() {
    $bd = conectarBaseDatos();
    $stmt = $bd->query("SELECT id, nombre FROM categorias");
    return $stmt->fetchAll();
}

# Registra todos los datos
function registrarPublicacion($titulo, $contenido, $referencias, $autor_nombre, $categoria_id) {
    $bd = conectarBaseDatos();
    $sql = "INSERT INTO publicaciones (titulo, contenido, referencias, autor_nombre, fecha_publicacion, categoria_id)
            VALUES (?, ?, ?, ?, NOW(), ?)";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$titulo, '', $referencias, $autor_nombre, $categoria_id]);
    return $bd->lastInsertId();
}

# Función para identificar si es imagen o texto
function registrarContenidoElemento($publicacion_id, $contenido_html) {
    $bd = conectarBaseDatos();
    $orden = 1;

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $contenido_html);

    $body = $doc->getElementsByTagName('body')->item(0);
    foreach ($body->childNodes as $nodo) {
        if ($nodo->nodeType == XML_ELEMENT_NODE) {
            if ($nodo->nodeName == 'p' || $nodo->nodeName == 'h1' || $nodo->nodeName == 'h2' || $nodo->nodeName == 'h3' || $nodo->nodeName == 'div') {
                $texto = trim($doc->saveHTML($nodo));
                if (!empty($texto)) {
                    $stmt = $bd->prepare("INSERT INTO publicacion_elementos (publicacion_id, contenido, tipo, orden) VALUES (?, ?, 'texto', ?)");
                    $stmt->execute([$publicacion_id, $texto, $orden++]);
                }
            } elseif ($nodo->nodeName == 'figure') {
                $img = $nodo->getElementsByTagName('img')->item(0);
                if ($img) {
                    $src = $img->getAttribute('src');
                    $stmt = $bd->prepare("INSERT INTO publicacion_elementos (publicacion_id, contenido, tipo, orden) VALUES (?, ?, 'imagen', ?)");
                    $stmt->execute([$publicacion_id, $src, $orden++]);
                }
            }
        }
    }
}



$mensaje = "";
if (isset($_POST['registrar'])) {
    $titulo = $_POST['publicacion'] ?? '';
    $contenido_html = $_POST['contenido'] ?? '';
    $referencias = $_POST['referencias'] ?? '';
    $autor_nombre = $_POST['autor_nombre'] ?? '';
    $categoria_id = $_POST['categoria'] ?? null;

    if (empty($titulo) || empty($contenido_html) || empty($referencias) || empty($autor_nombre) || empty($categoria_id)) {
        $mensaje = '<div class="alert alert-danger mt-3">Debes completar todos los campos obligatorios.</div>';
    } else {
        $publicacion_id = registrarPublicacion($titulo, $contenido_html, $referencias, $autor_nombre, $categoria_id);
        if ($publicacion_id) {
            registrarContenidoElemento($publicacion_id, $contenido_html);
            $mensaje = '<div class="alert alert-success mt-3">Publicación registrada con éxito.</div>';
            header("refresh:2;url=index_admin.php");
        } else {
            $mensaje = '<div class="alert alert-danger mt-3">Error al registrar la publicación.</div>';
        }
    }
}

$categorias = obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>
<body>
<div class="container mt-4">
    <h3>Agregar Publicación</h3>
    <?= $mensaje ?? "" ?>
    <form method="post">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="publicacion" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contenido</label>
            <textarea id="contenido" name="contenido" class="form-control"></textarea>
        </div>

        <div class="mb-3">
    <label>Referencias</label>
    <textarea name="referencias" class="form-control" placeholder="Ejemplo: https://ejemplo.com/articulo-uno"></textarea>
    <small class="text-muted">Puedes escribir una referencia por línea. Si solo pones el link, se convertirá en formato APA básico automáticamente.</small>
        </div>


        <div class="mb-3">
            <label>Nombre del Autor</label>
            <input type="text" name="autor_nombre" class="form-control">
        </div>

        <div class="mb-3">
            <label>Categoría</label>
            <select name="categoria" id = "categoria" class="form-select" >
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary">
            <a href="index_admin.php" class="btn btn-secondary"><i class="fa fa-times"></i> Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>

<script>
    ClassicEditor
        .create(document.querySelector('#contenido'), {
            ckfinder: {
                uploadUrl: 'subir_imagen.php'
            },
            toolbar: [
                'heading', '|','bold', 'italic', 'link', 'bulletedList', 'numberedList', 'imageUpload', '|', 'undo', 'redo'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>

