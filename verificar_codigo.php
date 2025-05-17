<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/recuperar_contraseña.css">
    <title>Verificar Código</title>
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
    </style>
</head>
<body>

<div class="contenedor-formulario">
    <div class="titulo-bloque">
        
        <p>Revisa tu correo electrónico y escribe el código que te enviamos para continuar.</p>
    </div> <!-- ✅ Se cierra correctamente aquí -->

    <?php
    require 'funciones.php';
   session_start();

    if (isset($_POST['verificar_codigo'])) {
        $usuario = trim($_POST['usuario']);
        $codigo_ingresado = trim($_POST['codigo']);

        if (empty($usuario) || empty($codigo_ingresado)) {
            echo '<div class="alert alert-danger">Por favor, completa todos los campos.</div>';
        } else {
            $bd = conectarBaseDatos();

            $stmt = $bd->prepare("SELECT codigo_verificacion FROM usuarios WHERE nombre_usuario = ?");
            $stmt->execute([$usuario]);
            $codigo_guardado = $stmt->fetchColumn();

            if (!$codigo_guardado) {
                echo '<div class="alert alert-danger">Error: No se encontró un código de verificación.</div>';
            } elseif ($codigo_guardado === $codigo_ingresado) {
                $_SESSION['usuario_verificado'] = $usuario;

                $stmt = $bd->prepare("UPDATE usuarios SET codigo_verificacion = NULL WHERE nombre_usuario = ?");
                $stmt->execute([$usuario]);

                header("Location: cambiar_contraseña.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">Código incorrecto.</div>';
            }
        }
    }
    ?>

    <form method="post">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="text" name="codigo" placeholder="Código de verificación" required>
        <input type="submit" name="verificar_codigo" value="Verificar Código">
    </form>
</div>

</body>
</html>
