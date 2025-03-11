<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/all.min.css">
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/agregar.css">
    <title>Añadir</title>
</head>
<body>
    <?php    
        session_start();

        //if(empty($_SESSION['usuario'])) header("location: login.php");

    ?>
    <div class="contenedor">
        <h3 class="Titulo">Agregar Publicación</h3>
        <form method="post" class="cuadros">
            <div class="mb-3">
                <label for="publicacion" class="form-label">Título</label>
                <input type="text" name="publicacion" class="cuadroTexto" id="publicacion" placeholder="Escribe el título" required>
            </div>
            <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <textarea name="contenido" class="cuadroTexto" id="contenido" placeholder="Escribe el contenido" required></textarea>
            </div>
            <div class="mb-3">
                <label for="autor_nombre" class="form-label">Nombre del Autor</label>
                <input type="text" name="autor_nombre" id="autor_nombre" class="cuadroTexto" placeholder="Escribe el nombre del autor" required>
            </div>
            <div class="text-center mt-3">
                <input type="submit" name="registrar" value="Registrar" class="boton">
                <a href="index_admin.php"><i class="fa fa-times"></i> Cancelar</a>
            </div>
        </form>
    </div>
</form>

    
<?php
    if(isset($_POST['registrar'])){
        $titulo = $_POST['publicacion'];
        $contenido = $_POST['contenido'];
        $autor_nombre = $_POST['autor_nombre'];

        if(empty($titulo) || empty($contenido) || empty($autor_nombre)){
            echo '
            <div class="container text-center col-10">
                <div class="alert alert-danger mt-3" role="alert">
                    Debes completar todos los datos.
                </div>
            </div>';
            return;
        } 

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
                 $pdo = new PDO($dsn, $user, $pass, $options);
                 return $pdo;
            } catch (PDOException $e) {
                 die("Error en la conexión: " . $e->getMessage());
            }
        }

        function insertar($sentencia, $parametros ){
            $bd = conectarBaseDatos();
            $respuesta = $bd->prepare($sentencia);
            return $respuesta->execute($parametros);
        }

        function registrarPublicacion($titulo, $contenido, $autor_nombre) {
            $sentencia = "INSERT INTO publicaciones (titulo, contenido, fecha_publicacion, autor_nombre) 
                          VALUES (?, ?, NOW(), ?)";
            $parametros = [$titulo, $contenido, $autor_nombre];
            return insertar($sentencia, $parametros);
        }

        $resultado = registrarPublicacion($titulo, $contenido, $autor_nombre);

        if($resultado){
            echo '
            <div class="container text-center col-10">
                <div class="alert alert-success mt-3" role="alert">
                    Publicación registrada con éxito.
                </div>
            </div>';
            header("refresh:2;url=index_admin.php");
        }
    }
    ?>
   
</body>
</html>