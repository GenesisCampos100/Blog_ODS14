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
    <title>Ventas</title>
</head>
<body>
    <?php
        $id = $_GET['id'];

        if (!$id) {
            echo'                
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">                    
                        No se ha seleccionado el producto.
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

        function eliminar($sentencia, $id ){
            $bd = conectarBaseDatos();
            $respuesta = $bd->prepare($sentencia);
            return $respuesta->execute([$id]);
        }

        function eliminarProducto($id){
            $sentencia = "DELETE FROM publicaciones WHERE id = ?";
            return eliminar($sentencia, $id);
        }

        $resultado = eliminarProducto($id);
        if(!$resultado){
            echo "Error al eliminar";
            return;
        }

        echo'
                <div class="container text-center col-10">
                    <div class="text-center alert alert-success mt-3" role="alert">
                        Publicación eliminado con éxito.                    
                    </div>
                </div>';

        // Duerme durante cinco segundos.
        // En la pagina no se muestrara nada
        // sleep(5);
        //header("Location: index_usuario.php");
        header("refresh:2;url=index_admin.php");
    ?>
</body>
</html>