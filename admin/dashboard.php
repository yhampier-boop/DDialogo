<?php
// admin/dashboard.php
require_once '../config/database.php';
session_start();

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
            border-left: 4px solid #e0020d;
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
            border-left: 4px solid #e0020d;
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
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="../assets/images/logo.png" alt="Diálogo y Desarrollo">
        </div>
        
        <div class="user-info">
            <div class="name"><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador') ?></div>
            <div class="role"><?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'admin') ?></div>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a class="nav-link" href="modules/reportajes/">
                <i class="fas fa-newspaper"></i> <span>Reportajes</span>
                <span class="badge"><?= $stats['reportajes'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/noticias/">
                <i class="fas fa-bullhorn"></i> <span>Noticias</span>
                <span class="badge"><?= $stats['noticias'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/boletines/">
                <i class="fas fa-file-pdf"></i> <span>Boletines</span>
                <span class="badge"><?= $stats['boletines'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/podcasts/">
                <i class="fas fa-podcast"></i> <span>Podcasts</span>
                <span class="badge"><?= $stats['podcasts'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/videos/">
                <i class="fas fa-video"></i> <span>Videos</span>
                <span class="badge"><?= $stats['videos'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="modules/autores/">
                <i class="fas fa-users"></i> <span>Autores</span>
                <span class="badge"><?= $stats['autores'] ?? 0 ?></span>
            </a>
            <a class="nav-link" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> <span>Salir</span>
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
            <div class="stat-card border-primary">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Reportajes</div>
                        <div class="number"><?= $stats['reportajes'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><i class="fas fa-newspaper"></i></div>
                </div>
            </div>
            
            <div class="stat-card border-success">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Noticias</div>
                        <div class="number"><?= $stats['noticias'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><i class="fas fa-bullhorn"></i></div>
                </div>
            </div>
            
            <div class="stat-card border-info">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Boletines</div>
                        <div class="number"><?= $stats['boletines'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><i class="fas fa-file-pdf"></i></div>
                </div>
            </div>
            
            <div class="stat-card border-warning">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Podcasts</div>
                        <div class="number"><?= $stats['podcasts'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><i class="fas fa-podcast"></i></div>
                </div>
            </div>
            
            <div class="stat-card border-danger">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Videos</div>
                        <div class="number"><?= $stats['videos'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><i class="fas fa-video"></i></div>
                </div>
            </div>
            
            <div class="stat-card border-dark">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="label">Autores</div>
                        <div class="number"><?= $stats['autores'] ?? 0 ?></div>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>



