<?php
session_start();

// Si viene de "nuevo", limpiar todo
if (isset($_GET['nuevo']) && $_GET['nuevo'] == 1) {
    unset($_SESSION['previa_data']);
    unset($_SESSION['imagen_portada_temp']);
}

// Si viene de "cancelar", repoblar los datos
if (isset($_GET['cancelar']) && $_GET['cancelar'] == 1) {
    $titulo = $_SESSION['previa_data']['titulo'] ?? '';
    $resumen = $_SESSION['previa_data']['resumen'] ?? '';
    $contenido_html = $_SESSION['previa_data']['contenido'] ?? '';
    $referencias = $_SESSION['previa_data']['referencias'] ?? '';
    $autor_nombre = $_SESSION['previa_data']['autor_nombre'] ?? '';
    $categoria_id = $_SESSION['previa_data']['categoria_id'] ?? '';
    $imagen_portada = $_SESSION['imagen_portada_temp'] ?? '';


} else {
    // Entrar desde cero (formulario limpio)
    $titulo = '';
    $resumen = '';
    $contenido_html = '';
    $referencias = '';
    $autor_nombre = '';
    $categoria_id = '';
}


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
function registrarPublicacion($titulo, $resumen, $contenido, $referencias, $autor_nombre, $categoria_id, $imagen_portada) {
    $bd = conectarBaseDatos();
    $sql = "INSERT INTO publicaciones (titulo, resumen, contenido, referencias, autor_nombre, fecha_publicacion, categoria_id, imagen_portada)
            VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$titulo, $resumen, $contenido, $referencias, $autor_nombre, $categoria_id, $imagen_portada]);
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
            if (
                $nodo->nodeName == 'p' ||
                $nodo->nodeName == 'h1' ||
                $nodo->nodeName == 'h2' ||
                $nodo->nodeName == 'h3' ||
                $nodo->nodeName == 'div' ||
                $nodo->nodeName == 'ul' ||
                $nodo->nodeName == 'ol' ||
                $nodo->nodeName == 'li' ||
                $nodo->nodeName == 'a' ||
                $nodo->nodeName == 'strong' ||
                $nodo->nodeName == 'b' ||
                $nodo->nodeName == 'em' ||
                $nodo->nodeName == 'i'
            ) {
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


if (isset($_POST['previa'])) {
    // Capturamos los datos del formulario
    $titulo = $_POST['publicacion'] ?? '';
    $resumen = $_POST['resumen'] ?? '';
    $contenido_html = $_POST['contenido'] ?? '';
    $referencias = $_POST['referencias'] ?? '';
    $autor_nombre = $_POST['autor_nombre'] ?? '';
    $categoria_id = $_POST['categoria'] ?? null;

    $imagen_portada = ''; // importante declarar antes

    // Procesar imagen de portada
    if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = time() . '_' . basename($_FILES['imagen_portada']['name']);
        $rutaDestino = 'imagen_portada/' . $nombreArchivo;

        if (move_uploaded_file($_FILES['imagen_portada']['tmp_name'], $rutaDestino)) {
            $imagen_portada = $rutaDestino;
            $_SESSION['imagen_portada_temp'] = $imagen_portada; // guardar en sesión
        } else {
            $mensaje = '<div class="alert alert-warning mt-3">No se pudo subir la imagen de portada.</div>';
        }
    }

        // Si no se subió nueva imagen, usar la anterior guardada en sesión
    if (empty($imagen_portada) && isset($_SESSION['imagen_portada_temp'])) {
        $imagen_portada = $_SESSION['imagen_portada_temp'];
    }


    // Validación
    if (empty($titulo) || empty($resumen) || empty($contenido_html) || empty($referencias) || empty($autor_nombre) || empty($categoria_id)  || empty($imagen_portada)) {
        $mensaje = '<div class="alert alert-danger mt-3">Debes completar todos los campos.</div>';
    } else {
        

        // Guardar los demás datos temporalmente
        $_SESSION['previa_data'] = [
            'titulo' => $titulo,
            'resumen' => $resumen,
            'contenido' => $contenido_html,
            'referencias' => $referencias,
            'autor_nombre' => $autor_nombre,
            'categoria_id' => $categoria_id
            
        ];

        // Mostrar la vista previa
        include 'previa_publicacion.php';
        exit;
    }
}

//$imagen_portada = $_SESSION['imagen_portada_temp'] ?? '';
//$titulo = '';
//$resumen = '';
//$contenido_html = '';
//$referencias = '';
//$autor_nombre = '';
//$categoria_id = '';

//$mensaje = "";

if (isset($_POST['registrar'])) {
    $datos = $_SESSION['previa_data'] ?? [];
    $titulo = $datos['titulo'] ?? '';
    $resumen = $datos['resumen'] ?? '';
    $contenido_html = $datos['contenido'] ?? '';
    $referencias = $datos['referencias'] ?? '';
    $autor_nombre = $datos['autor_nombre'] ?? '';
    $categoria_id = $datos['categoria_id'] ?? null;
    $imagen_portada = $_SESSION['imagen_portada_temp'] ?? '';
    


        $publicacion_id = registrarPublicacion($titulo, $resumen, $contenido_html, $referencias, $autor_nombre, $categoria_id,$imagen_portada);
        if ($publicacion_id) {
            registrarContenidoElemento($publicacion_id, $contenido_html);
            $mensaje = '<div class="alert alert-success mt-3">Publicación registrada con éxito.</div>';
            
            // Limpia la sesión después de guardar
            unset($_SESSION['previa_data']);
            unset($_SESSION['imagen_portada_temp']);

            header("refresh:2;url=index_admin.php");
            exit;
        } else {
            $mensaje = '<div class="alert alert-danger mt-3">Error al registrar la publicación.</div>';
        }
    }


if (isset($_POST['cancelar'])) {
    header("Location: agregar_publicacion.php");
    exit;
}
$categorias = obtenerCategorias();    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/editar_publicacion.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>
<body>
<div class="container mt-4">
   
    <?php if (!empty($mensaje)) echo $mensaje; ?>
    <form method="post" enctype="multipart/form-data">

    <div class="mb-3"><center> <h3>Agregar Publicación</h3></center>
    <label>Título</label>
    <input type="text" name="publicacion" class="form-control" value="<?= htmlspecialchars($titulo) ?>">
    </div>

    <div class="mb-3">
    <label>Imagen de Portada</label>
    <input type="file" name="imagen_portada" accept="image/*" class="form-control">

    <?php if (!empty($imagen_portada)): ?>
        <div class="mt-2">
            <label>Imagen ya cargada:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($imagen_portada) ?>" readonly>

            <!-- Mostrar imagen -->
            <img src="<?= htmlspecialchars($imagen_portada) ?>" alt="Imagen de portada" style="max-width: 50%; height: auto; border: 1px solid #ccc; padding: 5px;">
        </div>
    <?php endif; ?>
</div>

        <div class="mb-3">
            <label>Resumen (previsualización del blog)</label>
            <textarea name="resumen" class="form-control"><?= htmlspecialchars($resumen) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Contenido</label>
            <textarea id="contenido" name="contenido" class="form-control"><?= htmlspecialchars($contenido_html) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Referencias</label>
            <textarea name="referencias" class="form-control" placeholder="Ejemplo: https://ejemplo.com/articulo-uno"><?= htmlspecialchars($referencias) ?></textarea>
            <small class="text-muted">Puedes escribir una referencia por línea. Si solo pones el link, se convertirá en formato APA básico automáticamente.</small>
        </div>


        <div class="mb-3">
            <label>Nombre del Autor</label>
            <input type="text" name="autor_nombre" class="form-control" value="<?= htmlspecialchars($autor_nombre) ?>">
        </div>


        <div class="mb-3">
            <label>Categoría</label>
            <select name="categoria" id = "categoria" class="form-select" >
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($categoria_id == $cat['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nombre']) ?>
            </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center mt-3">
        <input type="submit" name="previa" value="Listo (Previsualizar)" class="btn btn-success me-2">
        
            <button type="button" class="boton" onclick="mostrarModalVolver()">Cancelar</button>
        </div>
    </form>
</div>

<!-- Modal confirmar regreso -->
<div id="modal-volver" class="modal-cancelar">
    <div class="modal-caja">
        <p>¿Estás segura de que quieres volver al panel?<br><small>Se perderán los cambios no guardados.</small></p>
        <div class="botones-modal">
            <button onclick="ocultarModalVolver()" class="btn btn-outline-secondary">Cancelar</button>
            <a href="index_admin.php" class="btn btn-danger">Sí, volver</a>
        </div>
    </div>
</div>

<script>
function mostrarModalVolver() {
    document.getElementById('modal-volver').style.display = 'flex';
}

function ocultarModalVolver() {
    document.getElementById('modal-volver').style.display = 'none';
}
</script>
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

<script>
    ClassicEditor
        .create(document.querySelector('#imagen_portada'), {
            ckfinder: {
                uploadUrl: 'subir_imagen.php'
            },
            toolbar: [
             'imageUpload'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>

