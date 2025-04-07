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
    <title>Admin</title>
</head>
<body>
    <?php
        session_start();

        //if(empty($_SESSION['usuario'])) header("location: login.php");

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

        function obtenerClientes(){
            $sentencia = "SELECT * FROM publicaciones";
            return select($sentencia);
        }

        $clientes = obtenerClientes();
    ?>
    
        <h1 class="Titulo">
            
           Publicaciones
        </h1>

      

        <div class="contenedor">
        <div class="cuadros">
        <table class="table">
            <thead>
                <tr>
                    <th class="texto">No.</th>
                    <th class="texto"> Titulo</th>
                    <th class="texto">Autor</th>
                    <th class="texto">Fecha</th>
                    <th class="texto">Editar</th>
                    <th class="texto">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($clientes as $cliente){
                ?>
                    <tr class="cuadros">  
                        <td><?php echo $cliente->id; ?></td>
                        <td><?php echo $cliente->titulo; ?></td>
                        <td><?php echo $cliente->autor_nombre; ?></td>
                        <td><?php echo $cliente->fecha_publicacion; ?></td>
                        <td>
                            <a class="" href="editar_publicacion.php?id=<?php echo $cliente->id;?>">
                                <i class="fa fa-edit"></i>
                                Editar
                            </a>
                        </td>
                        <td>
                            <a class="" href="eliminar_publicacion.php?id=<?php echo $cliente->id;?>">
                                <i class="fa fa-trash"></i>
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table></div>
    <br>
    <a class="" href="agregar_publicacion.php">
    <i class="fa fa-plus"></i>
     Agregar
    </a>
    </div> 

    <?php
// Comprueba si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Si el usuario ha iniciado sesión, muestra el botón de cierre de sesión
    echo '<br> <div class="contenedor">';
    echo '<br><div class="">';
    echo '<a href="cerrar_sesion.php" class="texto">Cerrar Sesión</a>';
    echo '</div>';
    echo '<br>';
    echo '<div class="">';
    echo '<a href="cambiarContrasenia.php" class="texto">Cambiar Comtraseña</a>';
    echo '</div>';
    echo '<br>';
    echo '</div>';

    echo '<div class="mensaje-nivel">';
    echo '<p>Tu nivel de seguridad es: ' . $_SESSION['nivelSeguridad'] . '</p>';
    echo '</div>';

    echo '</div>';
}


?>

</center>
    
</body>
</html>