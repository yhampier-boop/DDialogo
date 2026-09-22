<?php
$host = 'localhost';
$dbname = 'dialogodesarrollo';
$username = 'root';
$password = '';

echo "========================================\n";
echo "🔍 PROBANDO CONEXIÓN A BASE DE DATOS\n";
echo "========================================\n\n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conexión exitosa a MySQL\n";
    echo "📊 Base de datos: $dbname\n\n";
    
    // Verificar tablas
    $stmt = $pdo->query("SHOW TABLES");
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📋 Tablas encontradas:\n";
    foreach ($tablas as $tabla) {
        $stmt2 = $pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $total = $stmt2->fetch()['total'];
        echo "   - 📁 $tabla: $total registros\n";
    }
    
    echo "\n========================================\n";
    echo "✅ PRUEBA COMPLETADA CON ÉXITO\n";
    echo "========================================\n";
    
} catch(PDOException $e) {
    echo "❌ ERROR DE CONEXIÓN:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "\n========================================\n";
    echo "🔧 POSIBLES SOLUCIONES:\n";
    echo "   1. Verifica que MySQL esté corriendo en XAMPP\n";
    echo "   2. Revisa que la base de datos 'dialogodesarrollo' exista\n";
    echo "   3. Verifica usuario y contraseña (root / vacío)\n";
    echo "========================================\n";
}
?>
