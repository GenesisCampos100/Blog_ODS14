<?php session_start(); 



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login_admin09.css">
</head>
 <!-- Ícono de idioma alineado -->
        <li class="nav-item mx-2 dropdown">
          <button id="botonIdioma" class="btn nav-link p-0 border-0 bg-transparent" 
                  data-bs-toggle="dropdown" aria-expanded="false">
            <img id="banderaIdioma" src="img/espana.png" alt="Idioma" style="height: 20px;">
          </button>
          <ul class="dropdown-menu" aria-labelledby="botonIdioma">
            <li><a class="dropdown-item" href="#" onclick="traducirContenido('es','en')">Inglés</a></li>
            <li><a class="dropdown-item" href="#" onclick="traducirContenido('en','es')">Español</a></li>
          </ul>
        </li>

<body>

<a href="index.php" class="return-btn">
    <i class='bx bx-left-arrow-alt'></i>
</a>



    <?php
    if (isset($_SESSION['mensaje'])) {
        $tipo = $_SESSION['tipo_mensaje'];
        $mensaje = $_SESSION['mensaje'];
        echo "<div class='custom-alert $tipo'>$mensaje</div>";
    }
    ?>

    <div class="container <?php echo isset($_SESSION['formulario_actual']) && $_SESSION['formulario_actual'] === 'registro' ? 'active' : ''; ?>">

        <!-- Login -->
        <div class="form-box login">
            <form action="controlador.php" method="POST">
                <h1 id="login3">Login</h1>
                <div class="input-box">
                    <input type="text" name="login_usuario" placeholder="Username">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="login_contrasenia" placeholder="Password">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button id="login" type="submit" name="btningresar" class="btn login-btn">Login</button>
                <p id="welcome">Welcome to Dipsy</p>
                <div class="forgot-link">
                    <a id="passaword" href="recuperar_contraseña.php">Forgot password?</a>
                </div>
            </form>
        </div>

        <!-- Registro -->
        <div class="form-box register">
            <form action="controlador.php" method="POST">
                <h1 id="register">Register</h1>
                <div class="input-box">
                    <input type="text" name="registrar-usuario" placeholder="Username">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="registrar-correo" placeholder="Email">
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="registrar-nombre" placeholder="First Name">
                    <i class='bx bxs-id-card'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="registrar-apellidos" placeholder="Last Name">
                    <i class='bx bxs-id-card'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="registrar-contrasenia" placeholder="Password">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="registrar-confirmar" placeholder="Confirm Password">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button id="register2" type="submit" name="btnregistrar" class="btn register-submit">Register</button>
            </form>
        </div>

        <!-- Toggle Panel -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1 id="hola">Hello, Welcome</h1>
                <p id="notaccount">Don't have an account?</p>
                <button id="register3" class="btn register-toggle">Register</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1 id="welcomeBack">Welcome Back</h1>
                <p id="haveaccount">Already have an account?</p>
                <button id="login2" class="btn login-toggle">Login</button>
            </div>
        </div>

    </div>

    <?php unset($_SESSION['formulario_actual'], $_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>

    <script>
        const container = document.querySelector('.container');
        const registerButtons = document.querySelectorAll('.register-toggle');
        const loginButtons = document.querySelectorAll('.login-toggle');

        registerButtons.forEach(button => {
            button.addEventListener('click', () => {
                container.classList.add('active');
            });
        });

        loginButtons.forEach(button => {
            button.addEventListener('click', () => {
                container.classList.remove('active');
            });
        });

        // Depuración: Muestra el estado de clases del contenedor
        console.log("Estado del contenedor:", container.classList);
        
        document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(".form-box input");

    // Recuperar valores guardados en localStorage
    inputs.forEach(input => {
        const savedValue = localStorage.getItem(input.name);
        if (savedValue) {
            input.value = savedValue;
        }

        // Guardar los cambios cada vez que el usuario escribe
        input.addEventListener("input", () => {
            localStorage.setItem(input.name, input.value);
        });
    });

    window.addEventListener("beforeunload", () => {
    localStorage.clear();
});

});

    

    </script>
    <script src ="traductor.js"></script>
</body>
</html>
