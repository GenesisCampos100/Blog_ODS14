<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhz6V0UogEc4f-rfAwAQpBoTYSDisG8JxxJMIV4dzHfSNq7pT-rnlvM8slL6amobEgw0-wcx5dqeaJmdqL1eMOg2kL8sPG-dqH28AB9dwoMtB_ZwL260q7zhM6SB20glizFCHh0oWwNi8U/s1600/focanadando.gif.gif'); /* Reemplaza con la URL de tu GIF */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            width: 80%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #218838;
        }
        .anonymous-btn {
            background-color: #007bff;
        }
        .anonymous-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2></h2>
    <form method = "post" id="loginForm">

        <?php
        include("conexion.php");
        include("controlador.php");
        ?>
        



    <h2>Registro</h2>
    <form method="POST">
        <input type="text" name="registrar-nombre" placeholder="Nombre(s)">
        <input type="text" name="registrar-apellido_paterno" placeholder="Apellido Paterno">
        <input type="text" name="registrar-apellido_materno" placeholder="Apellido Materno">
        <input type="email" name="registrar-correo" placeholder="Correo">
        <input type="text" name="registrar-usuario" placeholder="Usuario">
        <input type="password" name="registrar-contrasenia" placeholder="Contraseña">
        <button type="submit" name="btnregistrar">Registrar</button>
        <p>¿Ya tienes cuenta? <a href="login_admin.php" onclick="">Inicia sesión aquí</a></p>
    </form>


<div>
    </form>
</div>


</script>

</body>
</html>