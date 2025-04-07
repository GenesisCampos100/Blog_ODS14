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
$_SESSION['formulario_actual'] = 'registro';
    if (
        empty($_POST['registrar-nombre']) ||
        empty($_POST['registrar-apellido_paterno']) ||
        empty($_POST['registrar-apellido_materno']) ||
        empty($_POST['registrar-correo']) ||
        empty($_POST['registrar-usuario']) ||
        empty($_POST['registrar-contrasenia'])
    ) {
        echo '<div class="alert alert-warning mt-3 text-center">Todos los campos son obligatorios.</div>';
    } else {
        $nombre = filter_input(INPUT_POST, 'registrar-nombre', FILTER_SANITIZE_STRING);
        $apellido_paterno = filter_input(INPUT_POST, 'registrar-apellido_paterno', FILTER_SANITIZE_STRING);
        $apellido_materno = filter_input(INPUT_POST, 'registrar-apellido_materno', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'registrar-correo', FILTER_SANITIZE_EMAIL);
        $usuario = filter_input(INPUT_POST, 'registrar-usuario', FILTER_SANITIZE_STRING);
        $password = password_hash($_POST['registrar-contrasenia'], PASSWORD_DEFAULT); // Hash de contraseña

        $bd = conectarBaseDatos();
        $stmt = $bd->prepare("INSERT INTO admin (nombre, apellido_paterno, apellido_materno, correo, usuario, contrasenia) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nombre, $apellido_paterno, $apellido_materno, $correo, $usuario, $password])) {
            echo '<div class="alert alert-success mt-3 text-center">Registro exitoso. ¡Ahora puedes iniciar sesión!</div>';
        } else {
            echo '<div class="alert alert-danger mt-3 text-center">Error en el registro. Inténtalo de nuevo.</div>';
        }
    }
}
?>


</body>
</html>