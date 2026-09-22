<?php
require_once 'config/database.php';

echo "📋 NOTICIAS (campo foto):\n";
$stmt = $pdo->query("SELECT id, titulo, foto FROM noticias");
foreach ($stmt->fetchAll() as $n) {
    $foto = $n['foto'] ?? 'SIN FOTO';
    echo "   ID {$n['id']}: $foto\n";
}

echo "\n📋 REPORTAJES (campo foto_principal):\n";
$stmt = $pdo->query("SELECT id, titulo, foto_principal FROM reportajes");
foreach ($stmt->fetchAll() as $r) {
    $foto = $r['foto_principal'] ?? 'SIN FOTO';
    echo "   ID {$r['id']}: $foto\n";
}

echo "\n📋 BOLETINES (campo foto_portada):\n";
$stmt = $pdo->query("SELECT id, numero_boletin, foto_portada FROM boletines");
foreach ($stmt->fetchAll() as $b) {
    $foto = $b['foto_portada'] ?? 'SIN FOTO';
    echo "   ID {$b['id']}: $foto\n";
}

echo "\n📋 REPORT AJES_FOTOS (url_foto):\n";
$stmt = $pdo->query("SELECT id, reportaje_id, url_foto FROM reportajes_fotos");
foreach ($stmt->fetchAll() as $f) {
    echo "   ID {$f['id']} (reportaje {$f['reportaje_id']}): {$f['url_foto']}\n";
}
?>
