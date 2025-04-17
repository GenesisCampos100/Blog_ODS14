<?php
$carpetaDestino = "imagenes/"; // asegúrate de que esta carpeta exista y tenga permisos de escritura

if (!empty($_FILES['upload']['name'])) {
    $nombreArchivo = basename($_FILES['upload']['name']);
    $rutaCompleta = $carpetaDestino . time() . "_" . $nombreArchivo;

    if (move_uploaded_file($_FILES['upload']['tmp_name'], $rutaCompleta)) {
        $respuesta = [
            "uploaded" => true,
            "url" => $rutaCompleta
        ];
    } else {
        $respuesta = [
            "uploaded" => false,
            "error" => ["message" => "Error al subir la imagen."]
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
?>
