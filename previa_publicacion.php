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
$contenido = $datos['contenido'] ?? ''; // This variable holds the full HTML content
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vista Previa</title>

    <!-- Estilos de ver_publicacion.php -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estructurablog.css" rel="stylesheet"/>
    <link href="css/cartas.css" rel="stylesheet" />
    <link href="css/barra.css" rel="stylesheet" />
    <link href="css/general.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- jQuery (needed for some Bootstrap components, though not strictly for this preview structure) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Ajuste de altura para la barra azul (optional, depends if you want this visual element) -->
    <script>
      function ajustarAlturaBarra() {
        const img = document.getElementById('tituloimg');
        const barra = document.getElementById('barracolorr');
        if (img && barra) {
          barra.style.height = img.offsetHeight + 'px';
        }
      }
      window.addEventListener('load', ajustarAlturaBarra);
      window.addEventListener('resize', ajustarAlturaBarra);
    </script>

    <style>
        /* Keep modal styles from previa_publicacion.php */
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

        /* Optional: Adjust padding/margins for the preview container if needed */
    </style>
</head>
<body class="bg-light">

<!-- Optional: Blue bar visual element -->
<div id="barracolorr" class="barracolor"></div>

<div class="publicacionhomee">
    <div class="imagenportada">
        <img id="tituloimg" class="imgtituloblog" src="<?= htmlspecialchars($imagen_portada) ?>" alt="Imagen Portada" class="img-fluid">
    </div>

    <div class="categoriass">
        <!-- Link might not be necessary in preview, using # -->
        <a href="#" class="categoria-link">
            <div class="categoria"><?= htmlspecialchars($nombre_categoria) ?></div>
        </a>
    </div>

    <div class="titulopublicacion"><?= htmlspecialchars($titulo) ?></div>

    <div class="resumenpublicacion">
        <?= htmlspecialchars($resumen) ?>
    </div>

    <div class="autor">
        <div class="autor-info">
            <div class="autorr"><?= htmlspecialchars($autor) ?></div>
            <!-- Date can be placeholder or removed -->
            <div class="fecha">Fecha</div>
        </div>

<div class="comentariolink">COMENTARIOS</div>
    </div>

    <!-- Display the main content HTML directly -->
    <div class="textoblog">
        <?= $contenido ?>
    </div>

    <?php if (!empty($referencias)): ?>
        <div class="referencias">
            <div class="tituloref">Referencias</div>
            <div class="referenciass">
                <ul>
                    <?php
                    $lineas = explode("\n", $referencias);
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
    <?php endif; ?>

    <!-- Recommended posts section is excluded from preview -->
    <!-- <div class="publicacionesrecientes"> ... </div> -->

</div>

<!-- Buttons and Modals from previa_publicacion.php -->
<div class="mt-4 text-center" style="margin-bottom: 40px;">
    <button type="button" class="btn btn-success me-2" onclick="mostrarModalPublicar()">✅ Publicar</button>
    <button type="button" class="btn btn-secondary" onclick="mostrarModalCancelar()">❌ Cancelar</button>
</div>


<!-- Modal de confirmación Cancelar -->
<div id="modal-cancelar" class="modal-cancelar">
    <div class="modal-caja">
        <p>¿Estás seguro de que deseas cancelar y descartar esta publicación?</p>
        <div class="botones-modal">
            <button onclick="ocultarModalCancelar()" class="btn btn-outline-secondary">Volver</button>
            <a href="agregar_publicacion.php?cancelar=1" class="btn btn-danger">Sí, cancelar</a>
        </div>
    </div>
</div>

<!-- Modal de confirmación Publicar -->
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

function mostrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'flex';
}

function ocultarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}
</script>

<!-- Bootstrap Bundle JS (needed for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
