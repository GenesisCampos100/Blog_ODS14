<?php
// autenticacion.php


// Función para iniciar sesión
function iniciarSesion($id, $nombre, $recordar = true) {
    $_SESSION['usuario_id'] = $id;
    $_SESSION['usuario_nombre'] = $nombre;

    if ($recordar) {
        // Cookies válidas por 1 día
        setcookie("usuario_id", $id, time() + 86400, "/");
        setcookie("usuario_nombre", $nombre, time() + 86400, "/");
    }
}

// Función para verificar si está autenticado
function estaAutenticado() {
    if (isset($_SESSION['usuario_id'])) {
        return true;
    } elseif (isset($_COOKIE['usuario_id']) && isset($_COOKIE['usuario_nombre'])) {
        // Restaurar sesión desde cookies
        $_SESSION['usuario_id'] = $_COOKIE['usuario_id'];
        $_SESSION['usuario_nombre'] = $_COOKIE['usuario_nombre'];
        return true;
    }
    return false;
}

// Función para obtener el nombre del usuario
function obtenerNombreUsuario() {
    return $_SESSION['usuario_nombre'] ?? $_COOKIE['usuario_nombre'] ?? null;
}

// Función para cerrar sesión
function cerrarSesion() {
    session_unset();
    session_destroy();
    setcookie("usuario_id", "", time() - 3600, "/");
    setcookie("usuario_nombre", "", time() - 3600, "/");
}
?>
