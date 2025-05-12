<?php

// Registrar un nuevo comentario
function agregarComentario($publicacion_id, $usuario_id, $contenido) {
    $bd = conectarBaseDatos();
    $sql = "INSERT INTO comentarios (publicacion_id, usuario_id, contenido) VALUES (?, ?, ?)";
    $stmt = $bd->prepare($sql);

    // Verifica si hay un error al ejecutar la consulta
    if (!$stmt->execute([$publicacion_id, $usuario_id, $contenido])) {
        // Si ocurre un error, mostramos el mensaje de error
        echo "Error al insertar comentario: ";
        print_r($stmt->errorInfo());
        return false;
    }

    return true;
}

?>