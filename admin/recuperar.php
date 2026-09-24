<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../libs/mail_helper.php';
session_start();

$mensaje = '';
$tipo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $mensaje = 'Ingresa tu correo electronico';
        $tipo = 'danger';
    } else {
        $stmt = $pdo->prepare("SELECT id, nombres, ap_paterno, email FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $stmt = $pdo->prepare("UPDATE usuarios SET reset_token = ?, reset_expira = ? WHERE id = ?");
            $stmt->execute([$token, $expira, $user['id']]);
            
            $config = require __DIR__ . '/../config/mail.php';
            $link = $config['url_base'] . '/admin/reset.php?token=' . $token;
            
            $cuerpo = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">'
                . '<div style="background: #e0020d; padding: 20px; text-align: center;">'
                . '<h1 style="color: #fff; margin: 0;">Dialogo y Desarrollo</h1></div>'
                . '<div style="padding: 30px; background: #f9f9f9;">'
                . '<h2 style="color: #1a1a2e;">Recuperar contrasena</h2>'
                . '<p>Hola ' . htmlspecialchars($user['nombres']) . ',</p>'
                . '<p>Recibimos una solicitud para restablecer tu contrasena. Haz clic en el boton:</p>'
                . '<p style="text-align: center; margin: 30px 0;">'
                . '<a href="' . $link . '" style="background: #e0020d; color: #fff; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">Restablecer mi contrasena</a></p>'
                . '<p style="color: #666; font-size: 14px;">O copia este enlace en tu navegador:</p>'
                . '<p style="color: #666; font-size: 14px; word-break: break-all;">' . $link . '</p>'
                . '<p style="color: #e0020d; font-size: 14px;"><strong>Este enlace expira en 1 hora.</strong></p>'
                . '<p style="color: #999; font-size: 12px; margin-top: 30px;">Si no solicitaste este cambio, ignora este mensaje.</p>'
                . '</div>'
                . '<div style="background: #333; padding: 15px; text-align: center;">'
                . '<p style="color: #aaa; font-size: 12px; margin: 0;">(c) ' . date('Y') . ' Dialogo y Desarrollo Peru</p></div></div>';
            
            $resultado = enviarEmail(
                $user['email'],
                $user['nombres'] . ' ' . $user['ap_paterno'],
                'Recuperar contrasena - Dialogo y Desarrollo',
                $cuerpo
            );
            
            if ($resultado['success']) {
                $mensaje = 'Te enviamos un correo con las instrucciones. Revisa tu bandeja (y spam).';
                $tipo = 'success';
            } else {
                $mensaje = 'Error al enviar el correo: ' . $resultado['mensaje'];
                $tipo = 'danger';
            }
        } else {
            $mensaje = 'Si el correo existe en nuestro sistema, recibiras un email con las instrucciones.';
            $tipo = 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar Contrasena - Dialogo y Desarrollo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: Cabin, sans-serif; padding: 20px; }
.card { background: #fff; border-radius: 15px; padding: 50px 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); max-width: 420px; width: 100%; }
h1 { font-size: 24px; font-weight: 700; color: #1a1a2e; text-align: center; margin-bottom: 10px; }
.form-control { width: 100%; padding: 14px 18px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; }
.form-control:focus { border-color: #e0020d; outline: none; box-shadow: 0 0 0 4px rgba(224,2,13,0.1); }
.btn-primary { width: 100%; padding: 15px; background: #e0020d; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; }
.btn-primary:hover { background: #c0020b; }
.footer-text { text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #f0f0f0; font-size: 12px; }
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
    <img src="../assets/images/iconos/logo.png" alt="Logo" style="max-width: 180px; margin: 0 auto 20px; display:block;">
    <h1>Recuperar Contrasena</h1>
    <p style="color:#999; font-size:14px; text-align:center; margin-bottom:25px;">Ingresa tu correo y te enviaremos un enlace</p>
    
    <?php if ($mensaje): ?>
        <div style="padding:15px; border-radius:10px; background:<?= $tipo === 'success' ? '#e8f5e9' : '#fde8e8' ?>; color:<?= $tipo === 'success' ? '#2e7d32' : '#c0392b' ?>; font-size:14px; margin-bottom:20px;">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div style="margin-bottom:20px;">
            <label style="font-weight:600; font-size:14px; margin-bottom:8px; display:block;">Correo electronico</label>
            <input type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required autofocus>
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i> Enviar enlace</button>
    </form>
    
    <div class="footer-text">
        <a href="login.php" style="color:#e0020d; text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Volver al login
        </a>
    </div>
</div>
</body>
</html>