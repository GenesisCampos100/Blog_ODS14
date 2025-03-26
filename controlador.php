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

if(isset($_POST['btningresar'])){
    if(empty($_POST['usuario']) || empty($_POST['contrasenia'])){
        echo'
        <div class="container text-center col-10">
            <div class="alert alert-warning mt-3" role="alert">
                Debes completar todos los datos.
            </div>
        </div>';
        return;
    }        

    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'contrasenia', FILTER_SANITIZE_STRING);

    session_start();

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

    function verificarPassword($idUsuario, $password){
        $sentencia = "SELECT contrasenia FROM admin WHERE id = ?";
        $contrasenia = select($sentencia, [$idUsuario])[0]->contrasenia;
        $verifica = ($password === $contrasenia);
        if($verifica) return true;
    }

    function iniciarSesion($usuario, $password){
        $sentencia = "SELECT id, contrasenia FROM admin WHERE usuario  = ?";
        $resultado = select($sentencia, [$usuario]);
        if($resultado){
            $usuario = $resultado[0];
            $verificaPass = verificarPassword($usuario->id, $password);
            if($verificaPass) return $usuario;
        }
    }

    $datosSesion = iniciarSesion($usuario, $password);

    if(!$datosSesion){
        echo'
        <div class="alert alert-danger mt-3" role="alert">
            Nombre de usuario y/o contraseña incorrectas.
        </div>';
        return;
    }

    $_SESSION['usuario'] = $datosSesion->usuario;
    $_SESSION['idUsuario'] = $datosSesion->id;
    header("location: index_admin.php");
}
?>

</body>
</html>