<?php
$carpeta = 'imagenes_portada/'; // Carpeta donde se guardarán las imágenes

if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

if ($_FILES['upload']) {
    $archivo = $_FILES['upload'];
    $nombre = time() . "_" . basename($archivo['name']);
    $rutaFinal = $carpeta . $nombre;

    if (move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
        $respuesta = [
            "uploaded" => 1,
            "fileName" => $nombre,
            "url" => $rutaFinal
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
