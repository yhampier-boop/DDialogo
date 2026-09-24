<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($usuario) && !empty($password)) {
        // Buscar por email O por nombre de usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? OR nombres = ? LIMIT 1");
        $stmt->execute([$usuario, $usuario]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombres'] . ' ' . $user['ap_paterno'];
            $_SESSION['usuario_rol'] = $user['rol'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = '❌ Usuario o contraseña incorrectos';
        }
    } else {
        $error = '❌ Completa todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Diálogo y Desarrollo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cabin', 'Segoe UI', sans-serif;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        
        .login-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 50px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .login-header .logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 20px;
        }
        
        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 5px;
        }
        
        .login-header p {
            color: #999;
            font-size: 14px;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-group label i {
            color: #e0020d;
            margin-right: 5px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
            background: #fafafa;
        }
        
        .form-control:focus {
            border-color: #e0020d;
            outline: none;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(224, 2, 13, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background: #e0020d;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background: #c0020b;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(224, 2, 13, 0.3);
        }
        
        .btn-login i {
            margin-right: 8px;
        }
        
        .alert-danger {
            background: #fde8e8;
            color: #c0392b;
            border: 1px solid #f5c6cb;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            color: #bbb;
            font-size: 12px;
        }
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

    <div class="login-container">
        <div class="login-card">
            
            <div class="login-header">
                <img src="/Dialogoydesarrollo/assets/images/iconos/logo.png" alt="Diálogo y Desarrollo" class="logo">
                <h1>Panel de Administración</h1>
                <p>Diálogo y Desarrollo Perú</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Usuario</label>
                    <input type="text" name="usuario" class="form-control" placeholder="Ingresa tu usuario" required autofocus>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Ingresar
                </button>
            </form>
            
            <div class="footer-text">
                <p style="margin-bottom:10px;">
                    <a href="recuperar.php" style="color:#e0020d; text-decoration:none; font-size:13px;">
                        <i class="fas fa-question-circle"></i> ¿Olvidaste tu contraseña?
                    </a>
                </p>

                &copy; <?= date('Y') ?> Diálogo y Desarrollo Perú
            </div>
            
        </div>
    </div>

</body>
</html>



