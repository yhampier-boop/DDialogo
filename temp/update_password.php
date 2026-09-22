<?php
$host = 'localhost';
$dbname = 'dialogodesarrollo';
$username = 'root';
$password = '';

$email = 'admin@dialogodesarrollo.pe';
$nuevo_hash = '$2y$10$2TRwHFFQkxmHVlryEGVALu11XllRahwM2qzO4YWxWTG0GjiyfUc0O';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE email = ?");
    $stmt->execute([$nuevo_hash, $email]);
    
    if ($stmt->rowCount() > 0) {
        echo "✅ Contraseña actualizada correctamente\n";
        echo "📧 Email: $email\n";
        echo "🔑 Contraseña: Admin123!\n";
        echo "\n👉 Prueba en: http://localhost/Dialogoydesarrollo/login.php\n";
    } else {
        echo "❌ No se encontró el usuario con email: $email\n";
    }
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
