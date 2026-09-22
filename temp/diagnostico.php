<?php
// ============================================
// DIAGNÓSTICO DE LOGIN
// ============================================

$host = 'localhost';
$dbname = 'dialogodesarrollo';
$username = 'root';
$password = '';

$email = 'admin@dialogodesarrollo.pe';
$pass = 'Admin123!';

echo "========================================\n";
echo "🔍 PROBANDO LOGIN\n";
echo "========================================\n\n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conectado a la base de datos\n\n";
} catch(PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "\n";
    die();
}

// 1. Verificar si la tabla usuarios existe
echo "1️⃣ VERIFICANDO TABLA USUARIOS:\n";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
    if ($stmt->rowCount() > 0) {
        echo "   ✅ Tabla 'usuarios' existe\n\n";
    } else {
        echo "   ❌ Tabla 'usuarios' NO existe\n";
        echo "   📝 Creando tabla usuarios...\n";
        $pdo->exec("
            CREATE TABLE usuarios (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombres VARCHAR(100) NOT NULL,
                ap_paterno VARCHAR(100) NOT NULL,
                ap_materno VARCHAR(100) NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                rol ENUM('admin', 'editor', 'redactor') DEFAULT 'redactor',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        echo "   ✅ Tabla usuarios creada\n\n";
    }
} catch(PDOException $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n\n";
}

// 2. Buscar usuario admin
echo "2️⃣ BUSCANDO USUARIO ADMIN:\n";
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if ($usuario) {
    echo "   ✅ Usuario encontrado:\n";
    echo "      ID: {$usuario['id']}\n";
    echo "      Nombre: {$usuario['nombres']} {$usuario['ap_paterno']}\n";
    echo "      Email: {$usuario['email']}\n";
    echo "      Rol: {$usuario['rol']}\n";
    echo "      Hash: " . substr($usuario['password_hash'], 0, 30) . "...\n\n";
} else {
    echo "   ❌ Usuario NO encontrado\n";
    echo "   📝 Creando usuario admin...\n";
    $stmt = $pdo->prepare("
        INSERT INTO usuarios (nombres, ap_paterno, email, password_hash, rol) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        'Administrador',
        'Sistema',
        $email,
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'admin'
    ]);
    echo "   ✅ Usuario admin creado\n\n";
    
    // Volver a buscar
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
}

// 3. Verificar contraseña
echo "3️⃣ VERIFICANDO CONTRASEÑA:\n";
echo "   Contraseña probada: $pass\n";

if ($usuario && password_verify($pass, $usuario['password_hash'])) {
    echo "   ✅ CONTRASEÑA CORRECTA\n\n";
    echo "========================================\n";
    echo "✅ LOGIN EXITOSO\n";
    echo "========================================\n";
    echo "\n👉 Ve a: http://localhost/Dialogoydesarrollo/admin/login.php\n";
    echo "📧 $email\n";
    echo "🔑 $pass\n";
} else {
    echo "   ❌ CONTRASEÑA INCORRECTA\n";
    if ($usuario) {
        echo "   Hash almacenado: " . $usuario['password_hash'] . "\n";
    }
    
    // Generar nuevo hash
    $nuevo_hash = password_hash($pass, PASSWORD_DEFAULT);
    echo "\n   📝 Actualizando contraseña...\n";
    
    $stmt = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE email = ?");
    $stmt->execute([$nuevo_hash, $email]);
    
    echo "   ✅ Contraseña actualizada\n";
    echo "   Nuevo hash: $nuevo_hash\n\n";
    echo "========================================\n";
    echo "✅ CONTRASEÑA ACTUALIZADA\n";
    echo "========================================\n";
    echo "\n👉 Ve a: http://localhost/Dialogoydesarrollo/admin/login.php\n";
    echo "📧 $email\n";
    echo "🔑 $pass\n";
}

// 4. Verificar archivos
echo "\n4️⃣ VERIFICANDO ARCHIVOS:\n";
echo "   📄 config/database.php: " . (file_exists('config/database.php') ? '✅' : '❌') . "\n";
echo "   📄 admin/login.php: " . (file_exists('admin/login.php') ? '✅' : '❌') . "\n";
echo "   📄 admin/dashboard.php: " . (file_exists('admin/dashboard.php') ? '✅' : '❌') . "\n";

echo "\n========================================\n";
