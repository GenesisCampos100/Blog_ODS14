<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/recuperar_contraseña.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <title>Editar</title>
</head>


<?php
require 'funciones.php';
session_start();

if (!isset($_SESSION['usuario_verificado'])) {
    echo '<div class="alert alert-danger text-center">No tienes permisos para cambiar la contraseña.</div>';
    exit;
}

$usuario = $_SESSION['usuario_verificado'];

if (isset($_POST['cambiar_contraseña'])) {
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    if ($nueva_contraseña !== $confirmar_contraseña) {
        echo '<div class="alert alert-danger text-center">Las contraseñas no coinciden.</div>';
        exit;
    }

    $bd = conectarBaseDatos();
    $password_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

    $stmt = $bd->prepare("UPDATE usuarios SET contrasenia = ?, codigo_verificacion = NULL WHERE nombre_usuario = ?");
    $stmt->execute([$password_hash, $usuario]);

    //echo '<div class="alert alert-success text-center">Contraseña cambiada con éxito.</div>';
    session_destroy(); // Limpiar sesión después del cambio

    // Mostrar mensaje y redirigir
    echo '
        <div class="alert alert-success text-center">Contraseña cambiada con éxito. Redirigiendo al login...</div>
        <script>
            setTimeout(function() {
                window.location.href = "login_usuarios.php";
            }, 2000);
        </script>
    ';
    exit;

  
} 
?>


<form method="post">
    <input type="password" name="nueva_contraseña" placeholder="Nueva Contraseña">
    <input type="password" name="confirmar_contraseña" placeholder="Confirmar Contraseña">
    <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña">
</form>
