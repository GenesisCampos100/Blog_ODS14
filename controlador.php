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

        $sentencia = "SELECT id, contrasenia FROM admin WHERE usuario = ?";
        $resultado = select($sentencia, [$usuario]);

        if ($resultado && password_verify($password, $resultado[0]->contrasenia)) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['idUsuario'] = $resultado[0]->id;
            header("location: index_admin.php");
            exit();
        } else {
            $_SESSION['tipo_mensaje'] = 'error';
            $_SESSION['mensaje'] = 'Nombre de usuario y/o contraseña incorrectos.';
            header("Location:login_admin.php");
            exit();
        }
    }
}



// Validación de Inicio de Sesión
if (isset($_POST['btningresar'])) {
    $_SESSION['formulario_actual'] = 'login';

    if (empty($_POST['login_usuario']) || empty($_POST['login_contrasenia'])) {
        $_SESSION['tipo_mensaje'] = 'warning';
        $_SESSION['mensaje'] = 'Debes completar todos los datos.';
        header("Location: login_usuarios.php");
        exit();
    } else {
        $usuario = filter_input(INPUT_POST, 'login_usuario', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'login_contrasenia', FILTER_SANITIZE_STRING);

        $sentencia = "SELECT id, contrasenia FROM usuarios WHERE nombre_usuario = ?";
        $resultado = select($sentencia, [$usuario]);

        if ($resultado && password_verify($password, $resultado[0]->contrasenia)) {
            // Guardar el nombre del usuario en la sesión
            $_SESSION['usuario_nombre'] = $usuario;
            $_SESSION['idUsuario'] = $resultado[0]->id;

           $redirectUrl = "index.php"; // Valor por defecto

            if (isset($_SESSION['redirect_url'])) {
                $url = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);

                // Verifica que no sea login_usuarios.php (ni contenga la ruta)
                if (!str_contains($url, 'login_usuarios.php')) {
                    $redirectUrl = $url;
                }
            }

            header("Location: $redirectUrl");
            exit();

        } else {
            $_SESSION['tipo_mensaje'] = 'error';
            $_SESSION['mensaje'] = 'Nombre de usuario y/o contraseña incorrectos.';
            header("Location: login_usuarios.php");
            exit();
        }
    }
}

// Validación de Registro
if (isset($_POST['btnregistrar'])) {
    $_SESSION['formulario_actual'] = 'registro';
    // Recolectar y sanitizar
    $nombre_usuario = trim(filter_input(INPUT_POST, 'registrar-usuario', FILTER_SANITIZE_STRING));
    $correo = trim(filter_input(INPUT_POST, 'registrar-correo', FILTER_SANITIZE_EMAIL));
    $nombre = trim(filter_input(INPUT_POST, 'registrar-nombre', FILTER_SANITIZE_STRING));
    $apellidos = trim(filter_input(INPUT_POST, 'registrar-apellidos', FILTER_SANITIZE_STRING));
    $contrasenia = $_POST['registrar-contrasenia'] ?? '';
    $confirmar_contrasenia = $_POST['registrar-confirmar'] ?? '';

    // Validaciones
    if (!$nombre_usuario || !$correo || !$nombre || !$apellidos || !$contrasenia || !$confirmar_contrasenia) {
        $_SESSION['tipo_mensaje'] = 'warning';
        $_SESSION['mensaje'] = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['tipo_mensaje'] = 'warning';
        $_SESSION['mensaje'] = 'El correo no es válido.';
    } elseif ($contrasenia !== $confirmar_contrasenia) {
        $_SESSION['tipo_mensaje'] = 'warning';
        $_SESSION['mensaje'] = 'Las contraseñas no coinciden.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $contrasenia)) {
        $_SESSION['tipo_mensaje'] = 'warning';
        $_SESSION['mensaje'] = 'La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un carácter especial.';
        
    } else {
        $bd = conectarBaseDatos();

        $verificar = $bd->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
        $verificar->execute([$nombre_usuario, $correo]);

        if ($verificar->fetch()) {
            $_SESSION['tipo_mensaje'] = 'error';
            $_SESSION['mensaje'] = 'El usuario o correo ya están registrados.';
        } else {
            $hash = password_hash($contrasenia, PASSWORD_DEFAULT);
            $stmt = $bd->prepare("INSERT INTO usuarios (nombre_usuario, correo, nombre, apellidos, contrasenia) VALUES (?, ?, ?, ?, ?)");

            if ($stmt->execute([$nombre_usuario, $correo, $nombre, $apellidos, $hash])) {
                $_SESSION['tipo_mensaje'] = 'success';
                $_SESSION['mensaje'] = '¡Registro exitoso! Ya puedes iniciar sesión.';
            } else {
                $_SESSION['tipo_mensaje'] = 'error';
                $_SESSION['mensaje'] = 'Error al registrar. Intenta de nuevo.';
            }
        }
    }

    // Redirigir al mismo formulario
    $_SESSION['formulario_actual'] = 'registro';
    header("Location: login_usuarios.php");
   exit();
}

?>


</body>
</html>