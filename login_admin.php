<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login_admin09.css">
</head>

<?php
session_start();

// Mostrar el mensaje si existe
if (isset($_SESSION['mensaje'])) {
    $tipo = $_SESSION['tipo_mensaje'];
    $mensaje = $_SESSION['mensaje'];
    echo "<div class='custom-alert $tipo'>$mensaje</div>";
    unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
}

?>
        <body>
            
    <!-- Login Form -->
    <div class="container">
       
       <div class="form-box login">
       
           <form action="controlador_admin.php" method="POST">
               <h1>Iniciar Sesión</h1>
               <div class="input-box">
                   <input type="text" name="admin_usuario" placeholder="Usuario" >
                   <i class='bx bxs-user'></i>
               </div>
               <div class="input-box">
            <input type="password" name="admin_contrasenia" id="password" placeholder="Password" required>
            
            <i class='bx bx-show toggle-password' data-target="password" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
        </div>
               <button type="submit" name="btningresar_admin" class="btn">Entrar</button>
               
           </form>
       </div>
       
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hola, Bienvenido</h1>
            </div>
          
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