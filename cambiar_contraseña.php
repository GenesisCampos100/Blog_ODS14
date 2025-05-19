<?php
require 'funciones.php';
session_start();

$mensaje = '';
$clase_alerta = ''; // clase CSS dinámica para estilo

if (!isset($_SESSION['usuario_verificado'])) {
    $mensaje = 'No tienes permisos para cambiar la contraseña.';
    $clase_alerta = 'alerta-error';
} else {
    $usuario = $_SESSION['usuario_verificado'];

    if (isset($_POST['cambiar_contraseña'])) {
        $nueva_contraseña = trim($_POST['nueva_contraseña']);
        $confirmar_contraseña = trim($_POST['confirmar_contraseña']);

        if (empty($nueva_contraseña) || empty($confirmar_contraseña)) {
            $mensaje = 'Por favor, completa todos los campos.';
            $clase_alerta = 'alerta-error';
        } elseif ($nueva_contraseña !== $confirmar_contraseña) {
            $mensaje = 'Las contraseñas no coinciden.';
            $clase_alerta = 'alerta-error';
        } elseif (strlen($nueva_contraseña) < 8) {
            $mensaje = 'La contraseña debe tener al menos 8 caracteres.';
            $clase_alerta = 'alerta-error';
        } elseif (
            !preg_match('/[A-Z]/', $nueva_contraseña) ||
            !preg_match('/[a-z]/', $nueva_contraseña) ||
            !preg_match('/[0-9]/', $nueva_contraseña) ||
            !preg_match('/[\W_]/', $nueva_contraseña)
        ) {
            $mensaje = 'Debe contener mayúscula, minúscula, número y símbolo.';
            $clase_alerta = 'alerta-error';
        } else {
            $bd = conectarBaseDatos();
            $password_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $stmt = $bd->prepare("UPDATE usuarios SET contrasenia = ?, codigo_verificacion = NULL WHERE nombre_usuario = ?");
            $stmt->execute([$password_hash, $usuario]);

            session_destroy();
            $mensaje = 'Contraseña cambiada con éxito. Redirigiendo al login...';
            $clase_alerta = 'alerta-exito';

            echo "<script>
                setTimeout(function() {
                    window.location.href = 'login_usuarios.php';
                }, 2000);
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="css/recuperar_contraseña.css">
    <style>
        .contenedor-formulario {
    width: 100%;
    max-width: 500px; /* más ancho */
    margin: 100px auto;
    padding: 30px 40px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 0 25px rgba(0,0,0,0.12);
    position: relative;
    font-family: 'Segoe UI', sans-serif;
    font-size: 1.1rem;
}

.alerta {
    text-align: center;
    font-weight: 600;
    margin-bottom: 20px;
    padding: 14px;
    border-radius: 10px;
    animation: aparecer 0.3s ease;
    font-size: 1.05rem;
}

.alerta-exito {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alerta-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@keyframes aparecer {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

input[type="password"],
input[type="submit"] {
    width: 100%;
    padding: 14px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    transition: background-color 0.3s ease;
    border: none;
}

input[type="submit"]:hover {
    background-color: #0056b3;
    cursor: pointer;
}



    </style>
</head>
<body>

<div class="contenedor-formulario">
     <div class="titulo-bloque">
        <h2>Restablecer tu contraseña</h2>
        <p>Ingresa una nueva contraseña segura para tu cuenta.</p>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alerta <?= $clase_alerta ?>"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="post">
        <!-- Contraseña -->
        <div class="input-box">
            <input type="password" name="registrar-contrasenia" id="password1" placeholder="Password" required>
            
            <i class='bx bx-show toggle-password' data-target="password1" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
        </div>

        <!-- Confirmar contraseña -->
        <div class="input-box">
            <input type="password" name="registrar-confirmar" id="password2" placeholder="Confirm Password" required>
            
            <i class='bx bx-show toggle-password' data-target="password2" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
        </div>
<!-- Botón de envío -->
        <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña">
    </form>
</div>
</div>

<script>
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
        const inputId = icon.getAttribute('data-target');
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        } else {
            input.type = 'password';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        }
    });
});
</script>

</body>
</html>
