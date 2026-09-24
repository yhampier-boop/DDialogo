<?php
require_once __DIR__ . '/../config/database.php';
session_start();

$token = $_GET['token'] ?? '';
$error = '';
$exito = false;

if (empty($token)) { header('Location: login.php'); exit; }

$stmt = $pdo->prepare("SELECT id, nombres, email FROM usuarios WHERE reset_token = ? AND reset_expira > NOW() LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) { $error = 'El enlace es invalido o ya expiro. Solicita uno nuevo.'; }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user) {
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    if (strlen($password) < 6) {
        $error = 'La contrasena debe tener al menos 6 caracteres';
    } elseif ($password !== $password2) {
        $error = 'Las contrasenas no coinciden';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET password_hash = ?, reset_token = NULL, reset_expira = NULL WHERE id = ?");
        $stmt->execute([$hash, $user['id']]);
        $exito = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Contrasena - Dialogo y Desarrollo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: Cabin, sans-serif; padding: 20px; }
.card { background: #fff; border-radius: 15px; padding: 50px 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); max-width: 420px; width: 100%; }
h1 { font-size: 24px; font-weight: 700; color: #1a1a2e; text-align: center; margin-bottom: 25px; }
.form-control { width: 100%; padding: 14px 18px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; }
.form-control:focus { border-color: #e0020d; outline: none; box-shadow: 0 0 0 4px rgba(224,2,13,0.1); }
.btn-primary { width: 100%; padding: 15px; background: #e0020d; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; display:block; text-align:center; text-decoration:none; }
.btn-primary:hover { background: #c0020b; color: #fff; }
</style>
<!-- FontAwesome preload + fallback inline -->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2" as="font" type="font/woff2" crossorigin>
<style>
    @font-face {
        font-family: 'FontAwesome';
        src: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2') format('woff2'),
             url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff') format('woff'),
             url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: block;
    }
    .fa, .fas, .far, .fab { font-family: 'FontAwesome' !important; }
</style>
<style>
    .icon-close-x { display: none !important; }
    button.navbar-toggler[aria-expanded="true"] .icon-bars { display: none !important; }
    button.navbar-toggler[aria-expanded="true"] .icon-close-x { display: inline-block !important; }
</style>
</head>
<body>
<div class="card">
    <h1><i class="fas fa-lock" style="color:#e0020d;"></i> Nueva Contrasena</h1>
    <?php if ($exito): ?>
        <div style="padding:15px; border-radius:10px; background:#e8f5e9; color:#2e7d32; margin-bottom:20px;">
            Contrasena actualizada correctamente. Ya puedes iniciar sesion.
        </div>
        <a href="login.php" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Ir al login</a>
    <?php elseif ($error && !$user): ?>
        <div style="padding:15px; border-radius:10px; background:#fde8e8; color:#c0392b; margin-bottom:20px;">
            <?= htmlspecialchars($error) ?>
        </div>
        <a href="recuperar.php" class="btn-primary">Solicitar nuevo enlace</a>
    <?php else: ?>
        <?php if ($error): ?>
            <div style="padding:15px; border-radius:10px; background:#fde8e8; color:#c0392b; margin-bottom:20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <p style="color:#666; margin-bottom:20px; text-align:center;">Hola <strong><?= htmlspecialchars($user['nombres']) ?></strong>, ingresa tu nueva contrasena:</p>
        <form method="POST">
            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:14px; margin-bottom:8px; display:block;">Nueva contrasena</label>
                <input type="password" name="password" class="form-control" required minlength="6" autofocus>
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-weight:600; font-size:14px; margin-bottom:8px; display:block;">Repetir contrasena</label>
                <input type="password" name="password2" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Cambiar contrasena</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>