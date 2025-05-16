<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

if (!isset($_SESSION['usuario_id']) || empty($_POST['contenido'])) {
    header("Location: blog.php");
    exit();
}

// Guardamos el comentario
if (agregarComentario($_POST['publicacion_id'], $_SESSION['usuario_id'], $_POST['contenido'])) {
    header("Location: publicacion.php?id=" . $_POST['publicacion_id']);
} else {
    echo "Error al guardar el comentario.";
}
?>
