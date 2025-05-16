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

if (isset($_POST['verificar_codigo'])) {
    $usuario = trim($_POST['usuario']);
    $codigo_ingresado = trim($_POST['codigo']);

    if (empty($usuario) || empty($codigo_ingresado)) {
        echo '<div class="alert alert-danger text-center">Por favor, completa todos los campos.</div>';
    } else {
        $bd = conectarBaseDatos();

        // Obtener el código guardado para el usuario
        $stmt = $bd->prepare("SELECT codigo_verificacion FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$usuario]);
        $codigo_guardado = $stmt->fetchColumn();

        if (!$codigo_guardado) {
            echo '<div class="alert alert-danger text-center">Error: No se encontró un código de verificación.</div>';
        } elseif ($codigo_guardado === $codigo_ingresado) {
            // Código correcto
            $_SESSION['usuario_verificado'] = $usuario;

            // Borrar el código verificado
            $stmt = $bd->prepare("UPDATE usuarios SET codigo_verificacion = NULL WHERE nombre_usuario = ?");
            $stmt->execute([$usuario]);

            // Redirige a la página de cambio de contraseña
            header("Location: cambiar_contraseña.php");
            exit;
        } else {
            // Código incorrecto
            echo '<div class="alert alert-danger text-center">Código incorrecto.</div>';
        }
    }
}
?>

<!-- Formulario de verificación -->
<form method="post">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="text" name="codigo" placeholder="Código de verificación" required>
    <input type="submit" name="verificar_codigo" value="Verificar Código">
</form>
