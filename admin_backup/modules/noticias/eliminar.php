<?php
// admin/modules/noticias/eliminar.php
require_once '../../../config/database.php';
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../../login.php'); exit; }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
        $stmt->execute([$id]);
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
