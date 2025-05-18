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

// Validación de Inicio de Admin
if (isset($_POST['btningresar_admin'])) {

    if (empty($_POST['admin_usuario']) || empty($_POST['admin_contrasenia'])) {
        $_SESSION['tipo_mensaje'] = 'warning';
        $_SESSION['mensaje'] = 'Debes completar todos los datos.';
        header("Location: login_admin.php"); // Ajusta a tu archivo real
        exit();
    } else {
        $usuario = filter_input(INPUT_POST, 'admin_usuario', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'admin_contrasenia', FILTER_SANITIZE_STRING);

        $sentencia = "SELECT id, contrasena FROM admin WHERE usuario = ?";
        $resultado = select($sentencia, [$usuario]);

        if ($resultado && password_verify($password, $resultado[0]->contrasena)) {
    session_regenerate_id(true); // Evita secuestro de sesión
    $_SESSION['usuario'] = $usuario;
    $_SESSION['idUsuario'] = $resultado[0]->id;
    header("Location: index_admin.php");
    exit();

        } else {
            $_SESSION['tipo_mensaje'] = 'error';
            $_SESSION['mensaje'] = 'Nombre de usuario y/o contraseña incorrectos.';
            header("Location:login_admin.php");
            exit();
        }
    }
}



?>


</body>
</html>