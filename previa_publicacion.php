<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexion.php';
$bd = conectarBaseDatos();

$datos = $_SESSION['previa_data'] ?? [];
$imagen_portada = $_SESSION['imagen_portada_temp'] ?? '';

$titulo = $datos['titulo'] ?? '';
$resumen = $datos['resumen'] ?? '';
$contenido = $datos['contenido'] ?? '';
$referencias = $datos['referencias'] ?? '';
$autor = $datos['autor_nombre'] ?? '';
$categoria_id = $datos['categoria_id'] ?? '';

$nombre_categoria = '';

if ($categoria_id) {
    $stmt = $bd->prepare("SELECT nombre FROM categorias WHERE id = ?");
    $stmt->execute([$categoria_id]);
    $categoria = $stmt->fetch();
    $nombre_categoria = $categoria['nombre'] ?? 'Sin categoría';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Previa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .blog-preview {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .blog-preview img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .blog-preview h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .blog-preview .autor {
            font-style: italic;
            margin-bottom: 10px;
            color: #666;
        }
        .blog-preview .contenido {
            margin-top: 30px;
        }

        .modal-cancelar {
    display: none;
    position: fixed;
    z-index: 2000;
    top: 0; left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

.modal-caja {
    background: #fff;
    padding: 25px 35px;
    border-radius: 12px;
    box-shadow: 0 0 18px rgba(0,0,0,0.3);
    max-width: 400px;
    width: 90%;
    text-align: center;
}

.modal-caja p {
    font-size: 18px;
    margin-bottom: 20px;
}

.botones-modal {
    display: flex;
    justify-content: center;
    gap: 15px;
}

    </style>
</head>
<body class="bg-light">

<div class="blog-preview">

    <h1><?php echo htmlspecialchars($titulo); ?></h1>
    <p class="autor">Por <?php echo htmlspecialchars($autor); ?> | Categoría:<?= htmlspecialchars($nombre_categoria) ?></p>
    <p><strong>Resumen:</strong> <?php echo htmlspecialchars($resumen); ?></p>
    <div class="contenido">
        <?php echo $contenido; ?>
    </div>
    <hr>
    <p><strong>Referencias:</strong><br><?php echo nl2br(htmlspecialchars($referencias)); ?></p>

    <form method="post" action="agregar_publicacion.php" class="mt-4 text-center">
        <button type="button" class="btn btn-success me-2" onclick="mostrarModalPublicar()">✅ Publicar</button>

        <button type="button" class="btn btn-secondary" onclick="mostrarModalCancelar()">❌ Cancelar</button>
    </form>
</div>


<!-- Modal de confirmación -->
<div id="modal-cancelar" class="modal-cancelar">
    <div class="modal-caja">
        <p>¿Estás seguro de que deseas cancelar y descartar esta publicación?</p>
        <div class="botones-modal">
            <button onclick="ocultarModalCancelar()" class="btn btn-outline-secondary">Volver</button>
            <a href="agregar_publicacion.php?cancelar=1" class="btn btn-danger">Sí, cancelar</a>
        </div>
    </div>
</div>

<!-- Modal de confirmación para publicar -->
<div id="modal-publicar" class="modal-cancelar">
    <div class="modal-caja">
        <p>¿Estás seguro de que deseas publicar esta entrada?</p>
        <div class="botones-modal">
            <button onclick="ocultarModalPublicar()" class="btn btn-outline-secondary">Volver</button>
            <form method="post" action="agregar_publicacion.php">
                <button type="submit" name="registrar" class="btn btn-success">Sí, publicar</button>
            </form>
        </div>
    </div>
</div>

<script>
function mostrarModalPublicar() {
    document.getElementById('modal-publicar').style.display = 'flex';
}

function ocultarModalPublicar() {
    document.getElementById('modal-publicar').style.display = 'none';
}
</script>


<script>
function mostrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'flex';
}

function ocultarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}
</script>

</body>
</html>
