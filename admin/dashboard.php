<?php
// admin/dashboard.php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$stats = getEstadisticas($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cabin', 'Segoe UI', sans-serif;
            background: #f5f5f5;
            color: #1a1a2e;
        }
        
        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 0;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.06);
            border-right: 1px solid #f0f0f0;
        }
        
        .sidebar .logo-container {
            padding: 0 25px 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 15px;
        }
        
        .sidebar .logo-container img {
            max-width: 140px;
            height: auto;
        }
        
        .sidebar .user-info {
            padding: 15px 25px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 15px;
        }
        
        .sidebar .user-info .name {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a2e;
        }
        
        .sidebar .user-info .role {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }
        
        .sidebar .nav-link {
            color: #666;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            font-size: 14px;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            background: #fafafa;
            color: #e0020d;
            border-left-color: #e0020d;
        }
        
        .sidebar .nav-link.active {
            background: #fff5f5;
            color: #e0020d;
            border-left-color: #e0020d;
            font-weight: 600;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }
        
        .sidebar .nav-link .badge {
            background: #e0020d;
            color: #ffffff;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            margin-left: auto;
            font-weight: 600;
        }
        
        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        
        /* WELCOME CARD */
        .welcome {
            background: #ffffff;
            color: #1a1a2e;
            padding: 35px 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            
        }
        
        .welcome h2 {
            margin: 0;
            font-weight: 700;
            font-size: 26px;
            color: #1a1a2e;
        }
        
        .welcome h2 i {
            color: #e0020d;
            margin-right: 10px;
        }
        
        .welcome p {
            color: #888;
            margin: 5px 0 0 0;
            font-size: 15px;
        }
        
        /* STATS CARDS */
        .row-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }
        
        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1;
        }
        
        .stat-card .label {
            color: #999;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .stat-card .icon {
            font-size: 28px;
            opacity: 0.2;
            color: #1a1a2e;
        }
        
        .stat-card .stat-footer {
            margin-top: 15px;
            font-size: 12px;
            color: #bbb;
        }
        
        /* Colores de bordes */
        .border-primary { border-color: #667eea; }
        .border-success { border-color: #2ecc71; }
        .border-info { border-color: #1abc9c; }
        .border-warning { border-color: #f39c12; }
        .border-danger { border-color: #e74c3c; }
        .border-dark { border-color: #2c3e50; }
        
        /* Contenedor de tablas */
        .table-container {
            background: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 25px;
        }
        
        .table-container .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table-container .table-header h5 {
            margin: 0;
            font-weight: 700;
            color: #1a1a2e;
            font-size: 18px;
        }
        
        .table-container .table-header h5 i {
            color: #e0020d;
            margin-right: 8px;
        }
        
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-container table th {
            text-align: left;
            padding: 12px 10px;
            font-size: 13px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .table-container table td {
            padding: 15px 10px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 14px;
            color: #333;
        }
        
        .table-container table tr:hover {
            background: #fafafa;
        }
        
        .table-container table tr:last-child td {
            border-bottom: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            .sidebar .logo-container img {
                max-width: 40px;
            }
            .sidebar .user-info {
                display: none;
            }
            .sidebar .nav-link {
                padding: 15px;
                justify-content: center;
            }
            .sidebar .nav-link span {
                display: none;
            }
            .sidebar .nav-link .badge {
                display: none;
            }
            .main-content {
                margin-left: 70px;
                padding: 15px;
            }
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

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="../assets/images/iconos/logo.png" alt="Diálogo y Desarrollo">
        </div>
        
        <div class="user-info">
            <div class="name"><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador') ?></div>
            <div class="role"><?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'admin') ?></div>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="dashboard.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg> <span>Dashboard</span>
            </a>
            <a class="nav-link" href="modules/reportajes/">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 3H2v16h20V3zm-2 14H4V5h16v12zM6 7h12v2H6V7zm0 4h12v2H6v-2zm0 4h8v2H6v-2z"/></svg> <span>Reportajes</span>
                <span class="badge"><?= $stats['reportajes'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/noticias/">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 11v2h4v-2h-4zm-2 6.61c.96.71 2.21 1.65 3.2 2.39.4-.53.8-1.07 1.2-1.6-.99-.74-2.24-1.68-3.2-2.4-.4.54-.8 1.08-1.2 1.61zM20.4 5.6c-.4-.53-.8-1.07-1.2-1.6-.99.74-2.24 1.68-3.2 2.4.4.53.8 1.07 1.2 1.6.96-.72 2.21-1.65 3.2-2.4zM4 9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h1v4h2v-4h1l5 3V6L8 9H4zm11.5 3c0-1.33-.58-2.53-1.5-3.35v6.69c.92-.81 1.5-2.01 1.5-3.34z"/></svg> <span>Noticias</span>
                <span class="badge"><?= $stats['noticias'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/boletines/">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg> <span>Boletines</span>
                <span class="badge"><?= $stats['boletines'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/podcasts/">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zm0 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg> <span>Podcasts</span>
                <span class="badge"><?= $stats['podcasts'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/videos/">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg> <span>Videos</span>
                <span class="badge"><?= $stats['videos'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/autores/">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg> <span>Autores</span>
                <span class="badge"><?= $stats['autores'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="logout.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg> <span>Salir</span>
            </a>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        
        <!-- WELCOME -->
        <div class="welcome">
            <h2><i class="fas fa-chart-line"></i> Dashboard</h2>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador') ?> — <?= date('d/m/Y H:i') ?></p>
        </div>
        
        <!-- STATS CARDS -->
        <div class="row-stats">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Reportajes</div>
                        <div class="number"><?= $stats['reportajes'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 3H2v16h20V3zm-2 14H4V5h16v12zM6 7h12v2H6V7zm0 4h12v2H6v-2zm0 4h8v2H6v-2z"/></svg></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Noticias</div>
                        <div class="number"><?= $stats['noticias'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 11v2h4v-2h-4zm-2 6.61c.96.71 2.21 1.65 3.2 2.39.4-.53.8-1.07 1.2-1.6-.99-.74-2.24-1.68-3.2-2.4-.4.54-.8 1.08-1.2 1.61zM20.4 5.6c-.4-.53-.8-1.07-1.2-1.6-.99.74-2.24 1.68-3.2 2.4.4.53.8 1.07 1.2 1.6.96-.72 2.21-1.65 3.2-2.4zM4 9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h1v4h2v-4h1l5 3V6L8 9H4zm11.5 3c0-1.33-.58-2.53-1.5-3.35v6.69c.92-.81 1.5-2.01 1.5-3.34z"/></svg></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Boletines</div>
                        <div class="number"><?= $stats['boletines'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Podcasts</div>
                        <div class="number"><?= $stats['podcasts'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zm0 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Videos</div>
                        <div class="number"><?= $stats['videos'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Autores</div>
                        <div class="number"><?= $stats['autores'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></div>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>



