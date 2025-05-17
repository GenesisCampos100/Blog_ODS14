<?php
$carpetaDestino = "imagenes/"; // asegúrate de que esta carpeta exista y tenga permisos de escritura

if (!empty($_FILES['upload']['name'])) {
    $nombreArchivo = time() . "_" . basename($_FILES['upload']['name']);
    $rutaCompleta = $carpetaDestino . $nombreArchivo;

    if (move_uploaded_file($_FILES['upload']['tmp_name'], $rutaCompleta)) {
        $respuesta = [
            "uploaded" => 1, // <-- CKEditor espera un 1
            "fileName" => $nombreArchivo,
            "url" => $rutaCompleta
        ];
    } else {
        $respuesta = [
            "uploaded" => 0,
            "error" => ["message" => "Error al subir la imagen."]
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
?>