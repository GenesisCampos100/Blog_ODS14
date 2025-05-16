<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/recuperar_contraseña.css">
    
    <title>Editar</title>
</head>

<?php
require 'funciones.php';

if (isset($_POST['enviar_codigo'])) {
    $usuario = $_POST['usuario'];

    $bd = conectarBaseDatos();
    $stmt = $bd->prepare("SELECT correo FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
    $stmt->execute([$usuario, $usuario]);
    $userData = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$userData || empty($userData->correo)) {
        echo '<div class="alert alert-danger text-center">Error: No se encontró un correo válido para el usuario.</div>';
        exit;
    }

    $codigo = rand(100000, 999999);

    // CORREGIDO: busca por usuario o correo
    $stmt = $bd->prepare("UPDATE usuarios SET codigo_verificacion = ? WHERE nombre_usuario = ? OR correo = ?");
    $stmt->execute([$codigo, $usuario, $usuario]);

    if ($stmt->rowCount() > 0) {
        enviarCorreo($userData->correo, $codigo);
        echo '<div class="alert alert-success text-center">Código enviado al correo.</div>';
        header("Location: verificar_codigo.php");
        exit;
    } else {
        echo '<div class="alert alert-danger text-center">No se pudo guardar el código.</div>';
    }
}
?>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuario o Email" required>
    <input type="submit" name="enviar_codigo" value="Enviar Código">
</form>

<!-- ✅ Toast animado de resultado -->
<div id="toast" class="toast">
    <i id="toast-icon">✔</i>
    <p id="toast-text">¡Éxito!</p>
</div>

<script>
function mostrarToast(tipo, mensaje, redirigir = false) {
    const toast = document.getElementById('toast');
    const icono = document.getElementById('toast-icon');
    const texto = document.getElementById('toast-text');

    // Configura icono y clase
    if (tipo === 'exito') {
        icono.textContent = '✔';
        toast.className = 'toast exito';
    } else {
        icono.textContent = '✖';
        toast.className = 'toast error';
    }

    texto.textContent = mensaje;
    toast.style.display = 'block';

    // Ocultar después de 2.5 segundos
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.style.display = 'none';
            toast.style.opacity = '1';
            if (redirigir) {
                window.location.href = "verificar_codigo.php";
            }
        }, 500);
    }, 2500);
}

document.getElementById('formulario').addEventListener('submit', function(event) {
    event.preventDefault(); // No recargar

    const input = document.querySelector('input[name="usuario"]').value.trim();

    if (input === '') {
        mostrarToast('error', 'El campo no puede estar vacío.');
    } else {
        // Aquí podrías hacer una llamada AJAX para enviar el código.
        mostrarToast('exito', '¡Código enviado al correo!', true);
    }
});
</script>