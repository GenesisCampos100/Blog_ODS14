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
    <title>Eliminar Publicación</title>
</head>
<body>
<?php
    $id = $_GET['id'];

    if (!$id) {
        echo'                
            <div class="container text-center col-10">
                <div class="alert alert-danger mt-3" role="alert">                    
                    No se ha seleccionado la publicación.
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

    function eliminar($sentencia, $parametros ){
        $bd = conectarBaseDatos();
        $respuesta = $bd->prepare($sentencia);
        return $respuesta->execute($parametros);
    }

    function eliminarElementosPublicacion($id_publicacion){
        $sentencia = "DELETE FROM publicacion_elementos WHERE publicacion_id = ?";
        return eliminar($sentencia, [$id_publicacion]);
    }

    function eliminarPublicacion($id){
        $sentencia = "DELETE FROM publicaciones WHERE id = ?";
        return eliminar($sentencia, [$id]);
    }

    // Primero borramos los elementos relacionados
    eliminarElementosPublicacion($id);

    // Luego la publicación principal
    $resultado = eliminarPublicacion($id);

    if(!$resultado){
        echo "Error al eliminar";
        return;
    }

    echo '
        <div class="container text-center col-10">
            <div class="text-center alert alert-success mt-3" role="alert">
                Publicación eliminada con éxito.                    
            </div>
        </div>';

    header("refresh:1;url=index_admin.php");
?>
</body>
</html>
