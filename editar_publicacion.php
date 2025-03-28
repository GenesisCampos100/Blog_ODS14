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
    <link rel="stylesheet" href="css/admin.css">
    <title>Ventas</title>
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

        $cliente = obtenerClientePorId($id);
    ?>
<form method="POST">
<div class="mb-3">
    <label for="publicacion" class="form-label">Título</label>
    <input type="text" name="publicacion" class="cuadroTexto" id="publicacion" 
        value="<?php echo htmlspecialchars($cliente->titulo ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
        placeholder="Escribe el título" required>
</div>

<div class="mb-3">
    <label for="contenido" class="form-label">Contenido</label>
    <textarea name="contenido" class="cuadroTexto" id="contenido" placeholder="Escribe el contenido" required><?php echo htmlspecialchars($cliente->contenido ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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
                    Cancelar
                </a>
            </div>
        </form>
    </div>
    
    <?php
        if(isset($_POST['registrar'])){
            $titulo = $_POST['publicacion'];
            $contenido = $_POST['contenido'];
            $autor_nombre = $_POST['autor_nombre'];

            if(empty($titulo) || empty($contenido) || empty($autor_nombre)){
                echo'
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">
                        Debes completar todos los datos.
                    </div>
                </div>';
                return;
            } 

            function editar($sentencia, $parametros ){
                $bd = conectarBaseDatos();
                $respuesta = $bd->prepare($sentencia);
                return $respuesta->execute($parametros);
            }

            function editarCliente($id,$titulo, $contenido, $autor_nombre){
                $sentencia = "UPDATE publicaciones SET titulo = ?, contenido = ?, autor_nombre = ? WHERE id = ?";
                $parametros = [$titulo, $contenido, $autor_nombre, $id];
                return editar($sentencia, $parametros);
            }            
            
            $resultado = editarCliente($id,$titulo, $contenido, $autor_nombre);
            if($resultado){
                echo'
                <div class="container text-center col-10">
                    <div class="alert alert-success mt-3" role="alert">
                        Información del cliente actualizada con éxito.
                    </div>
                </div>';
            }
            
            // Duerme durante cinco segundos.
            // En la pagina no se muestrara nada
            // sleep(5);
            //header("Location: index_usuario.php");
            header("refresh:2;url=index_admin.php");
            
        }
    ?>    
</body>
</html>