<?php
// config/database.php

$host = 'localhost';
$dbname = 'dialogodesarrollo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

function getEstadisticas($pdo) {
    $tablas = ['reportajes', 'noticias', 'boletines', 'podcasts', 'videos', 'autores'];
    $stats = [];
    foreach ($tablas as $tabla) {
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $stats[$tabla] = $stmt->fetch()['total'];
    }
    return $stats;
}

// Función para subir archivos
function subirArchivo($archivo, $carpeta, $tiposPermitidos = [], $maxSize = 10) {
    $respuesta = ['success' => false, 'mensaje' => '', 'ruta' => ''];
    
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        $respuesta['mensaje'] = 'Error al subir el archivo';
        return $respuesta;
    }
    
    $nombreOriginal = $archivo['name'];
    $tipo = $archivo['type'];
    $tamano = $archivo['size'] / 1024 / 1024; // MB
    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
    
    // Validar tamaño (máximo 10MB por defecto)
    if ($tamano > $maxSize) {
        $respuesta['mensaje'] = "El archivo excede el tamaño máximo de {$maxSize}MB";
        return $respuesta;
    }
    
    // Validar tipo
    if (!empty($tiposPermitidos) && !in_array($extension, $tiposPermitidos)) {
        $respuesta['mensaje'] = 'Tipo de archivo no permitido. Extensiones permitidas: ' . implode(', ', $tiposPermitidos);
        return $respuesta;
    }
    
    // Generar nombre único
    $nombreUnico = date('Ymd_His') . '_' . uniqid() . '.' . $extension;
    $rutaDestino = $carpeta . '/' . $nombreUnico;
    
    // Crear carpeta si no existe
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    
    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        $respuesta['success'] = true;
        $respuesta['mensaje'] = 'Archivo subido exitosamente';
        $respuesta['ruta'] = $rutaDestino;
    } else {
        $respuesta['mensaje'] = 'Error al mover el archivo';
    }
    
    return $respuesta;
}
?>
