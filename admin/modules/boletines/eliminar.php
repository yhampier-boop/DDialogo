<?php
require_once '../../../config/database.php';
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../../login.php'); exit; }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT archivo_pdf, foto_portada FROM boletines WHERE id = ?");
        $stmt->execute([$id]);
        $boletin = $stmt->fetch();

        $stmt = $pdo->prepare("DELETE FROM boletines WHERE id = ?");
        $stmt->execute([$id]);

        if ($boletin) {
            if (!empty($boletin['archivo_pdf'])) eliminarArchivo($boletin['archivo_pdf']);
            if (!empty($boletin['foto_portada'])) eliminarArchivo($boletin['foto_portada']);
        }

        header('Location: index.php?mensaje=eliminado');
        exit;
    } catch(PDOException $e) {
        header('Location: index.php?error=1');
        exit;
    }
}
header('Location: index.php');
exit;
?>