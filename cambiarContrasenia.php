<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/all.min.css">
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/admin.css">
    <title>Cambiar Contraseña</title>
</head>
<body>
<h3 class="Titulo">Cambiar Pasword</h3>
<div class="contenedor">
    
    <form method="post" class="cuadros">
        <div class="mb-3">
            <label for="contraseña_actual" class="form-label">Usuario</label>
            <input type="text" name="usuario" class="cuadroTexto" id="contraseña_actual" placeholder="Ingresa tu usuario">
        </div>

        <div class="mb-3">
            <label for="nueva_contraseña" class="form-label">Nueva Contraseña</label><br>
            <input type="password" name="nueva_contraseña" class="cuadroTexto" id="nueva_contraseña" placeholder="Escribe la nueva contraseña">
        </div>

        <!-- Nueva caja de texto para confirmar la nueva contraseña -->
        <div class="mb-3">
            <label for="confirmar_contraseña" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="confirmar_contraseña" class="cuadroTexto" id="confirmar_contraseña" placeholder="Confirma la nueva contraseña">
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña" class="boton">     
        </div>
    </form>
</div>

<?php
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

if (isset($_POST['cambiar_contraseña'])) {
    $usuario = $_POST['usuario'];
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    if (empty($usuario) || empty($nueva_contraseña) || empty($confirmar_contraseña)) {
        echo '
        <div class="container text-center col-10">
            <div class="alert alert-danger mt-3" role="alert">
                Debes ingresar tu usuario, la nueva contraseña y la confirmación.
            </div>
        </div>';
    } elseif ($nueva_contraseña !== $confirmar_contraseña) {
        echo '
        <div class="container text-center col-10">
            <div class="alert alert-danger mt-3" role="alert">
                Las contraseñas no coinciden. Inténtalo de nuevo.
            </div>
        </div>';
    } else {
        function cambiarContraseña($usuario, $nueva_contraseña) {
            $bd = conectarBaseDatos();

            // Verificar si el usuario existe
            $stmt = $bd->prepare("SELECT * FROM admin WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $resultado = $stmt->fetch();

            if (!$resultado) {
                return "Usuario no encontrado.";
            }

            // Encriptar la nueva contraseña
            // $password_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

            $password_hash = $nueva_contraseña; // Guardar la contraseña sin encriptar


            // Actualizar la contraseña en la base de datos
            $stmt = $bd->prepare("UPDATE admin SET contrasenia = ? WHERE usuario = ?");
            $exito = $stmt->execute([$password_hash, $usuario]);

           

            return $exito ? "Contraseña cambiada con éxito." : "Error al cambiar la contraseña.";
           
        }

        $mensaje = cambiarContraseña($usuario, $nueva_contraseña);

        echo '
        <div class="container text-center col-10">
            <div class="alert ' . ($mensaje == "Contraseña cambiada con éxito." ? 'alert-success' : 'alert-danger') . ' mt-3" role="alert">
                ' . $mensaje . '
                 <a href="login.php">Regresar</a>
            </div>
        </div>';
    }
}
?>


</body>
</html>