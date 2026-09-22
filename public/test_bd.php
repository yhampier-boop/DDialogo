<?php
require_once '../config/database.php';
$stmt = $pdo->query("SELECT COUNT(*) as total FROM noticias");
$total = $stmt->fetch()['total'];
echo "✅ Conexión OK - $total noticias en BD";
?>
