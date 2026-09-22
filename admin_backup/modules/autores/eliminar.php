<?php
// admin/modules/autores/eliminar.php
require_once '../../../config/database.php';
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../../login.php'); exit; }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    try {
        // Verificar si el autor tiene reportajes asociados
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM reportajes WHERE autor_id = ?");
        $stmt->execute([$id]);
        $total = $stmt->fetch()['total'];
        
        if ($total > 0) {
            header('Location: index.php?error=1&total=' . $total);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM autores WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: index.php?mensaje=eliminado');
        exit;
    } catch(PDOException $e) {
        header('Location: index.php?error=2');
        exit;
    }
}
header('Location: index.php');
exit;
?>
