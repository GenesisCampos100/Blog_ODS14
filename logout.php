<?php
session_start();

// Eliminar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redirigir al inicio (ajusta la ruta si es necesario)
header("Location: index.php");
exit();
?>
