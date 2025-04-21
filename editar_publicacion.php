<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <title>Editar</title>
</head>
<body>
    <?php
        session_start();

        //if(empty($_SESSION['usuario'])) header("location: login.php");

        $id = $_GET['id'];
        if (!$id) {
            echo'                
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">                    
                        No se ha seleccionado el cliente.
                    </div>
                </div>'; 
            exit;
        }

        function conectarBaseDatos() {
            $host = "localhost";
            $db   = "login";
            $user = "root";
            $pass = "";
            $charset = 'utf8mb4';
        
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            try {
                 $pdo = new \PDO($dsn, $user, $pass, $options);
                 return $pdo;
            } catch (\PDOException $e) {
                 throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        function select($sentencia, $parametros = []){
            $bd = conectarBaseDatos();
            $respuesta = $bd->prepare($sentencia);
            $respuesta->execute($parametros);
            return $respuesta->fetchAll();
        }

        function obtenerClientePorId($id){
            $sentencia = "SELECT * FROM publicaciones WHERE id = ?";
            $cliente = select($sentencia, [$id]);
            if($cliente) return $cliente[0];
        }

        function obtenerContenidoCompleto($id_publicacion) {
            $bd = conectarBaseDatos();
            $sentencia = "SELECT * FROM publicacion_elementos WHERE publicacion_id = ? ORDER BY orden ASC";
            $elementos = select($sentencia, [$id_publicacion]);
        
            $html = '';
        
            foreach ($elementos as $elemento) {
                if ($elemento->tipo == 'texto') {
                    // No envolvemos el contenido en <p>, ya viene como HTML completo
                    $html .= $elemento->contenido;
                } elseif ($elemento->tipo == 'imagen') {
                    $html .= '<img src="' . htmlspecialchars($elemento->contenido) . '" alt="Imagen" style="max-width:100%;">';
                }
            }
        
            return $html;
        }
        
        $contenidoReconstruido = obtenerContenidoCompleto($id);
        $cliente = obtenerClientePorId($id);
    ?>


<form method="POST" enctype="multipart/form-data">
<div class="mb-3">
    <label for="publicacion" class="form-label">Título</label>
    <input type="text" name="publicacion" class="cuadroTexto" id="publicacion" 
        value="<?php echo htmlspecialchars($cliente->titulo ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
        placeholder="Escribe el título" required>
</div>


<div class="mb-3">
    <label for="contenido" class="form-label">Contenido</label>
    
<textarea name="contenido" id="contenido"><?php echo $contenidoReconstruido; ?></textarea>

</div>

<div class="mb-3">
    <label for="autor_nombre" class="form-label">Nombre del Autor</label>
    <input type="text" name="autor_nombre" id="autor_nombre" class="cuadroTexto" 
        value="<?php echo htmlspecialchars($cliente->autor_nombre ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
        placeholder="Escribe el nombre del autor" required>

            <div class="text-center mt-3">
                <input type="submit" name="registrar" value="Registrar" class="boton">
                </input>

                
                <a href="index_admin.php" class="boton">
                    <i class=""></i> 
                    Volver al panel
                </a>
            </div>
    </div>
  </form>  


    <?php
if(isset($_POST['registrar'])){
    $titulo = $_POST['publicacion'];
    $contenido = $_POST['contenido'];
    $autor_nombre = $_POST['autor_nombre'];

    $imagen_portada = $cliente->imagen_portada; // valor actual


    if(empty($titulo) || empty($contenido) || empty($autor_nombre)){
        echo'
        <div class="container text-center col-10">
            <div class="alert alert-danger mt-3" role="alert">
                Debes completar todos los datos.
            </div>
        </div>';
    } 

    function editar($sentencia, $parametros ){
        $bd = conectarBaseDatos();
        $respuesta = $bd->prepare($sentencia);
        return $respuesta->execute($parametros);
    }

    function editarCliente($id, $titulo, $autor_nombre, $imagen_portada){
        $sentencia = "UPDATE publicaciones SET titulo = ?, autor_nombre = ?, imagen_portada = ? WHERE id = ?";
        $parametros = [$titulo, $autor_nombre, $imagen_portada, $id];
        return editar($sentencia, $parametros);
    }

    function borrarElementosPublicacion($id_publicacion) {
        $bd = conectarBaseDatos();
        $sentencia = "DELETE FROM publicacion_elementos WHERE publicacion_id = ?";
        $stmt = $bd->prepare($sentencia);
        $stmt->execute([$id_publicacion]);
    }

    function insertarElemento($publicacion_id, $tipo, $contenido, $orden) {
        $bd = conectarBaseDatos();
        $sentencia = "INSERT INTO publicacion_elementos (publicacion_id, tipo, contenido, orden) VALUES (?, ?, ?, ?)";
        $stmt = $bd->prepare($sentencia);
        $stmt->execute([$publicacion_id, $tipo, $contenido, $orden]);
    }
    

    // Primero editamos la publicación base
    $resultado = editarCliente($id, $titulo, $autor_nombre, $imagen_portada);

    if ($resultado) {
        borrarElementosPublicacion($id);
    
        libxml_use_internal_errors(true);
        //echo "<pre>" . htmlspecialchars($contenido) . "</pre>";

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($contenido, 'HTML-ENTITIES', 'UTF-8'));
        $orden = 0;
        $xpath = new DOMXPath($dom);
    
       foreach ($xpath->query('//body/*') as $node) {
        if ($node->nodeType === XML_ELEMENT_NODE) {

            if ($node->nodeName === 'figure') {
                $img = $node->getElementsByTagName('img')[0];
                if ($img) {
                    $src = $img->getAttribute('src');
                    if (!empty($src)) {
                        insertarElemento($id, 'imagen', $src, $orden++);
                       // echo "Imagen desde figure guardada: $src";
                    }
                }
                continue;
            }
            

            // Imagen suelta
            if ($node->nodeName === 'img') {
                $src = $node->getAttribute('src');
                if (!empty($src)) {
                    //echo "🖼 Imagen suelta detectada: $src<br>";
                    insertarElemento($id, 'imagen', $src, $orden++);
                }
                continue;
            }

        // Bloque que puede tener texto o imagen
        if (in_array($node->nodeName, ['p', 'h1', 'h2', 'h3', 'div', 'ul', 'ol', 'li', 'a', 'strong', 'b', 'em', 'i', 'figure'])) {

            $imgs = $node->getElementsByTagName('img');
            $onlyImage = true;

            // Verificamos si contiene solo imagen sin texto visible
            foreach ($node->childNodes as $child) {
                if (
                    $child->nodeType === XML_TEXT_NODE &&
                    trim($child->textContent) !== ''
                ) {
                    $onlyImage = false;
                    break;
                }
                if (
                    $child->nodeType === XML_ELEMENT_NODE &&
                    $child->nodeName !== 'img'
                ) {
                    $onlyImage = false;
                    break;
                }
            }

            if ($imgs->length === 1 && $onlyImage) {
                $img = $imgs[0];
                $src = $img->getAttribute('src');
                if (!empty($src)) {
                    //echo "🖼 Imagen detectada como única dentro de bloque: $src<br>";
                    insertarElemento($id, 'imagen', $src, $orden++);
                }
            } else {
                $html = $dom->saveHTML($node);
                //echo "📝 Bloque con texto o contenido mixto:<br>" . htmlspecialchars($html) . "<br><br>";
                insertarElemento($id, 'texto', $html, $orden++);
            }
        }
    }
}

    
        // Si quieres mostrar un mensaje (opcional)
        echo '
        <div class="container text-center col-10">
            <div class="alert alert-success mt-3" role="alert">
                Información de la publicación actualizada con éxito.
            </div>
        </div>';
    
        $contenidoReconstruido = obtenerContenidoCompleto($id);
        $cliente = obtenerClientePorId($id);
    }
    
}
?>

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