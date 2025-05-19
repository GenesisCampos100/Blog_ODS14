<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/recuperar_contraseña.css">
     <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Enviar Código</title>


    <style>
        .contenedor-formulario {
            max-width: 450px;
            margin: 100px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', sans-serif;
        }

        .alert {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1rem;
            text-align: center;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .return-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 70px; /* 💙 Tamaño del botón */
    height: 70px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    color: #fff; /* 💙 Color del ícono */
    background: #0077b6; /* 💙 Azul que combina mejor */
    border-radius: 12px; /* 🔵 Esquinas redondeadas */
    transition: transform 0.3s ease, background-color 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* ✨ Efecto de sombra */
}

/* 🌟 Animación al pasar el mouse */
.return-btn:hover {
    transform: scale(1.15); /* 🔄 Crece suavemente */
    background-color: #0096c7; /* 💙 Azul más brillante */
}

@keyframes fadeOut {
    0% {
        opacity: 1;
        transform: scale(1);
    }
    100% {
        opacity: 0;
        transform: scale(0.95);
    }
}

.fade-out {
    animation: fadeOut 0.4s ease forwards;
}

.input-box {
    position: relative;
}

.input-box input {
    width: 100%;
    padding-right: 40px; /* espacio para el ícono */
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
    color: #555;
}

    </style>
</head>
<body>

<a href="login_usuarios.php" class="return-btn">
    <i class='bx bx-left-arrow-alt'></i>
</a>

<div class="contenedor-formulario">
  <div class="titulo-bloque">
    <h2>Verifica tu cuenta</h2>
    <p>Por favor, ingresa tu usuario o correo electrónico para enviarte el código de verificación.</p>


    <?php
    require 'funciones.php';
    $mensaje = '';

    if (isset($_POST['enviar_codigo'])) {
        $usuario = trim($_POST['usuario']);

        if (empty($usuario)) {
            $mensaje = '<div class="alert alert-danger">El campo no puede estar vacío.</div>';
        } else {
            $bd = conectarBaseDatos();
            $stmt = $bd->prepare("SELECT correo FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
            $stmt->execute([$usuario, $usuario]);
            $userData = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$userData || empty($userData->correo)) {
                $mensaje = '<div class="alert alert-danger">Error: No se encontró un correo válido para el usuario.</div>';
            } else {
                $codigo = rand(100000, 999999);
                $stmt = $bd->prepare("UPDATE usuarios SET codigo_verificacion = ? WHERE nombre_usuario = ? OR correo = ?");
                $stmt->execute([$codigo, $usuario, $usuario]);

                if ($stmt->rowCount() > 0) {
                    enviarCorreo($userData->correo, $codigo);
                    $mensaje = '<div class="alert alert-success">Código enviado al correo. Redirigiendo...</div>';
                    echo $mensaje;
                    echo '
                        <script>
                            setTimeout(function() {
                                window.location.href = "verificar_codigo.php";
                            }, 2000);
                        </script>';
                    exit;
                } else {
                    $mensaje = '<div class="alert alert-danger">No se pudo guardar el código.</div>';
                }
            }
        }

        echo $mensaje;
    }
    ?>

    <!-- Formulario -->
    <form method="post">
        <input type="text" name="usuario" placeholder="Usuario o Email" required>
        <input type="submit" name="enviar_codigo" value="Enviar Código">
    </form>
</div>


</body>
</html>
