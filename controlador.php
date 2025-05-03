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
    <title>Controlador</title>
</head>
<body>
<?php    

session_start();

// Función para conectar a la base de datos
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
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}

// Función para ejecutar SELECT
function select($sentencia, $parametros = []) {
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
}

// Validación de Inicio de Sesión
if (isset($_POST['btningresar'])) {
$_SESSION['formulario_actual'] = 'login';
    if (empty($_POST['login_usuario']) || empty($_POST['login_contrasenia'])) {
        echo '<div class="alert alert-warning mt-3 text-center">Debes completar todos los datos.</div>';
       

    } else {
        $usuario = filter_input(INPUT_POST, 'login_usuario', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'login_contrasenia', FILTER_SANITIZE_STRING);

        $sentencia = "SELECT id, contrasenia FROM admin WHERE usuario = ?";
        $resultado = select($sentencia, [$usuario]);

        if ($resultado && password_verify($password, $resultado[0]->contrasenia)) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['idUsuario'] = $resultado[0]->id;
            header("location: index_admin.php");
            exit();
        } else {
            echo '<div class="alert alert-danger mt-3 text-center">Nombre de usuario y/o contraseña incorrectos.</div>';
        }
    }
}

// Validación de Registro
if (isset($_POST['btnregistrar'])) {
    // Recolectar y sanitizar
    $nombre_usuario = trim(filter_input(INPUT_POST, 'registrar-usuario', FILTER_SANITIZE_STRING));
    $correo = trim(filter_input(INPUT_POST, 'registrar-correo', FILTER_SANITIZE_EMAIL));
    $nombre = trim(filter_input(INPUT_POST, 'registrar-nombre', FILTER_SANITIZE_STRING));
    $apellidos = trim(filter_input(INPUT_POST, 'registrar-apellidos', FILTER_SANITIZE_STRING));
    $contrasenia = $_POST['registrar-contrasenia'] ?? '';
    $confirmar_contrasenia = $_POST['registrar-confirmar'] ?? '';

    // Validaciones
    if (!$nombre_usuario || !$correo || !$nombre || !$apellidos || !$contrasenia || !$confirmar_contrasenia) {
        echo '<div class="alert alert-warning text-center mt-3">Todos los campos son obligatorios.</div>';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-warning text-center mt-3">El correo no es válido.</div>';
    } elseif ($contrasenia !== $confirmar_contrasenia) {
        echo '<div class="alert alert-warning text-center mt-3">Las contraseñas no coinciden.</div>';
    } else {
        $bd = conectarBaseDatos();

        // Verificar si el usuario o correo ya existe
        $verificar = $bd->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
        $verificar->execute([$nombre_usuario, $correo]);

        if ($verificar->fetch()) {
            echo '<div class="alert alert-danger text-center mt-3">El usuario o correo ya están registrados.</div>';
        } else {
            // Insertar en la tabla usuarios
            $hash = password_hash($contrasenia, PASSWORD_DEFAULT);
            $stmt = $bd->prepare("INSERT INTO usuarios (nombre_usuario, correo, nombre, apellidos, contraseña) VALUES (?, ?, ?, ?, ?)");

            if ($stmt->execute([$nombre_usuario, $correo, $nombre, $apellidos, $hash])) {
                echo '<div class="alert alert-success text-center mt-3">¡Registro exitoso! Ya puedes iniciar sesión.</div>';
            } else {
                echo '<div class="alert alert-danger text-center mt-3">Error al registrar. Intenta de nuevo.</div>';
            }
        }
    }
}

?>


</body>
</html>