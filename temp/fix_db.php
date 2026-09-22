<?php
$host = 'localhost';
$dbname = 'dialogodesarrollo';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "========================================\n";
    echo "🔧 VERIFICANDO AUTORES\n";
    echo "========================================\n\n";
    
    // Verificar autores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM autores");
    $totalAutores = $stmt->fetch()['total'];
    
    if ($totalAutores == 0) {
        echo "📝 No hay autores. Insertando autores de prueba...\n";
        $pdo->exec("INSERT INTO autores (nombres, ap_paterno, nickname, es_nickname) VALUES
            ('Juan Carlos', 'Gómez', 'jcgomez', 1),
            ('María', 'Fernández', NULL, 0),
            ('Roberto', 'Sánchez', 'rsanchez', 1),
            ('Ana', 'Martínez', 'anam', 1),
            ('Carlos', 'Pérez', NULL, 0)");
        echo "✅ 5 autores creados\n\n";
    } else {
        echo "✅ Autores encontrados: $totalAutores\n\n";
    }
    
    // Verificar reportajes
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM reportajes");
    $totalReportajes = $stmt->fetch()['total'];
    
    if ($totalReportajes == 0) {
        echo "📝 No hay reportajes. Insertando reportajes de prueba...\n";
        
        // Obtener el primer autor
        $stmt = $pdo->query("SELECT id FROM autores LIMIT 1");
        $autorId = $stmt->fetch()['id'];
        
        $pdo->exec("INSERT INTO reportajes (titulo, resumen_corto, desarrollo, foto_principal, fecha_publicacion, es_destacado, autor_id, usuario_id) VALUES
            ('La minería ilegal en el Perú', 'Análisis completo sobre la minería ilegal', 'Desarrollo completo del reportaje sobre minería ilegal...', 'https://via.placeholder.com/800x400/3498db/ffffff?text=Minería+Ilegal', CURDATE(), 1, $autorId, 1),
            ('El canon minero y su impacto', 'Cómo el canon transforma las regiones mineras', 'Desarrollo completo del reportaje sobre canon minero...', 'https://via.placeholder.com/800x400/2ecc71/ffffff?text=Canon+Minero', CURDATE(), 0, $autorId, 1),
            ('Conflictos sociales en minería', 'Análisis de los principales conflictos', 'Desarrollo completo del reportaje sobre conflictos sociales...', 'https://via.placeholder.com/800x400/e74c3c/ffffff?text=Conflictos+Sociales', CURDATE(), 0, $autorId, 1)");
        echo "✅ 3 reportajes creados\n\n";
    } else {
        echo "✅ Reportajes encontrados: $totalReportajes\n\n";
    }
    
    // Verificar usuario admin
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute(['admin@dialogodesarrollo.pe']);
    $admin = $stmt->fetch();
    
    if (!$admin) {
        echo "📝 Creando usuario admin...\n";
        $pdo->exec("INSERT INTO usuarios (nombres, ap_paterno, email, password_hash, rol) VALUES
            ('Administrador', 'Sistema', 'admin@dialogodesarrollo.pe', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')");
        echo "✅ Usuario admin creado\n\n";
    }
    
    echo "========================================\n";
    echo "✅ TODO LISTO PARA PROBAR\n";
    echo "========================================\n";
    echo "\n👉 Ve a: http://localhost/Dialogoydesarrollo/reportajes_lista.php\n";
    echo "👉 Credenciales: admin@dialogodesarrollo.pe / Admin123!\n";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
