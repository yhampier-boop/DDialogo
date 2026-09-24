<?php
// config/database.php

// Lee de variables de entorno (Railway) o usa valores por defecto (local)
$host     = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?: 'localhost';
$dbname   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?: 'dialogodesarrollo';
$username = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?: 'root';
$password = $_ENV['DB_PASS']     ?? getenv('DB_PASS')     ?: '';
$port     = $_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}

function getEstadisticas($pdo) {
    $tablas = ['reportajes', 'noticias', 'boletines', 'podcasts', 'videos', 'autores'];
    $stats = [];
    foreach ($tablas as $tabla) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM $tabla");
            $stats[$tabla] = $stmt->fetch()['total'];
        } catch(PDOException $e) {
            $stats[$tabla] = 0;
        }
    }
    return $stats;
}

/**
 * Sube un archivo con validacion de tipo, tamano y seguridad
 */
function subirArchivo($archivo, $carpeta, $tiposPermitidos = ['jpg','jpeg','png','gif','webp'], $maxSizeMB = 3) {
    $respuesta = ['success' => false, 'mensaje' => '', 'ruta' => ''];

    if (!isset($archivo['error']) || $archivo['error'] !== UPLOAD_ERR_OK) {
        $errores = [
            UPLOAD_ERR_INI_SIZE   => 'El archivo excede el tamano permitido por el servidor',
            UPLOAD_ERR_FORM_SIZE  => 'El archivo excede el tamano permitido',
            UPLOAD_ERR_PARTIAL    => 'La subida se interrumpio',
            UPLOAD_ERR_NO_FILE    => 'No se selecciono ningun archivo',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta carpeta temporal',
            UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo',
        ];
        $respuesta['mensaje'] = $errores[$archivo['error']] ?? 'Error desconocido al subir';
        return $respuesta;
    }

    $tamanoMB = $archivo['size'] / 1024 / 1024;
    if ($tamanoMB > $maxSizeMB) {
        $respuesta['mensaje'] = "La imagen pesa " . round($tamanoMB, 1) . "MB. Maximo permitido: {$maxSizeMB}MB";
        return $respuesta;
    }

    $nombreOriginal = $archivo['name'];
    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
    if (!in_array($extension, $tiposPermitidos)) {
        $respuesta['mensaje'] = 'Formato no permitido. Usa: ' . implode(', ', $tiposPermitidos);
        return $respuesta;
    }

    // Validar segun tipo
    if ($extension === 'pdf') {
        $handle = fopen($archivo['tmp_name'], 'r');
        $primerosBytes = fread($handle, 4);
        fclose($handle);
        if ($primerosBytes !== '%PDF') {
            $respuesta['mensaje'] = 'El archivo no es un PDF valido';
            return $respuesta;
        }
    } else {
        $infoImagen = @getimagesize($archivo['tmp_name']);
        if ($infoImagen === false) {
            $respuesta['mensaje'] = 'El archivo no es una imagen valida';
            return $respuesta;
        }
    }

    // Ruta dentro del proyecto
    $carpetaAbsoluta = __DIR__ . '/../' . $carpeta;
    if (!is_dir($carpetaAbsoluta)) {
        if (!mkdir($carpetaAbsoluta, 0755, true)) {
            $respuesta['mensaje'] = 'No se pudo crear la carpeta de destino';
            return $respuesta;
        }
    }

    $nombreUnico = date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    $rutaRelativa = $carpeta . '/' . $nombreUnico;
    $rutaAbsoluta = $carpetaAbsoluta . '/' . $nombreUnico;

    if (!move_uploaded_file($archivo['tmp_name'], $rutaAbsoluta)) {
        $respuesta['mensaje'] = 'Error al guardar el archivo en el servidor';
        return $respuesta;
    }

    $respuesta['success'] = true;
    $respuesta['mensaje'] = 'Imagen subida correctamente';
    $respuesta['ruta'] = $rutaRelativa;

    return $respuesta;
}

/**
 * Elimina un archivo del servidor de forma segura
 */
function eliminarArchivo($rutaRelativa) {
    if (empty($rutaRelativa)) return false;
    $rutaAbsoluta = __DIR__ . '/../' . $rutaRelativa;
    if (file_exists($rutaAbsoluta) && is_file($rutaAbsoluta)) {
        return @unlink($rutaAbsoluta);
    }
    return false;
}