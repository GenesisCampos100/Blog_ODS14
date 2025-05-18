<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/administrador.css">
    <title>Admin</title>
</head>
<body>


    <?php
        
session_start(); // Iniciar sesión

// Si no hay sesión iniciada, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login_admin.php"); // Redirige al login si el usuario no está autenticado
    exit;
}



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
           $sentencia = "SELECT * FROM publicaciones ORDER BY fecha_publicacion DESC";
            return select($sentencia);
        }

        $clientes = obtenerClientes();
    ?>
    
        <div class="publicaciones-container">
        <h1>Publicaciones</h1>
        <a class="btn agregar" href="agregar_publicacion.php">
            <i class="fa fa-plus"></i> Agregar +
        </a>
        </div>
    
        

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
                $contador = 1; // Iniciar el contador
                foreach($clientes as $cliente){
                ?>
                    <tr class="cuadros">  
                        <td><?php echo $contador; ?></td> <!-- Número consecutivo -->
                        <td><?php echo $cliente->titulo; ?></td>
                        <td><?php echo $cliente->autor_nombre; ?></td>
                        <td><?php echo $cliente->fecha_publicacion; ?></td>
                        <td>
                           <a class="btn editar" href="editar_publicacion.php?id=<?php echo $cliente->id;?>">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            </a>
                        </td>
                        <td>

                            
                            <a class="btn eliminar" onclick="confirmarEliminacion(<?php echo $cliente->id; ?>)">
    <i class="fa fa-trash"></i> Eliminar
</a>

                     </td>
                    </tr>
                <?php
                     $contador++; // Incrementar el número
                    } ?>
            </tbody>
        </table></div>
   
    </div> 
    

    <?php

// Comprueba si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    echo '
    <br>
    <div class="contenedor text-center">
    <button onclick="confirmarCerrarSesion()" class="btn-cerrar-sesion">Cerrar Sesión</button>
</div>


    <!-- Modal de confirmación -->
    <div id="modalCerrarSesion" class="modal">
        <div class="modal-contenido">
            <p>¿Estás seguro de que deseas cerrar sesión?</p>
            <div class="botones-modal">
                <button onclick="cerrarSesion()" class="btn-confirmar">Sí, cerrar</button>
                <button onclick="cerrarModal()" class="btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        function confirmarCerrarSesion() {
            document.getElementById("modalCerrarSesion").style.display = "flex";
        }

        function cerrarModal() {
            document.getElementById("modalCerrarSesion").style.display = "none";
        }

        function cerrarSesion() {
            window.location.href = "cerrar_sesion.php";
        }
    </script>
    ';
}

?>

</center>

<div id="modal-confirmacion" class="modal">
    <div class="modal-contenido">
        <p>¿Estás seguro de que deseas eliminar esta publicación?</p>
        <div class="botones">
            <button onclick="cancelarEliminacion()">Cancelar</button>
            <a id="confirmar-boton" class="btn confirmar">Eliminar</a>
        </div>
    </div>
</div>

<script>
function confirmarEliminacion(id) {
    const modal = document.getElementById("modal-confirmacion");
    const confirmarBtn = document.getElementById("confirmar-boton");
    confirmarBtn.href = "eliminar_publicacion.php?id=" + id;
    modal.style.display = "flex";
}

function cancelarEliminacion() {
    document.getElementById("modal-confirmacion").style.display = "none";
}
</script>

    
</body>
</html>