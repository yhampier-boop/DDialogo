<?php
// podcasts.php - Lista de podcasts
require_once 'config/database.php';

$stmt = $pdo->query("SELECT * FROM podcasts ORDER BY fecha_publicacion DESC");
$podcasts = $stmt->fetchAll();

function fechaMes($fecha) {
    if (empty($fecha)) return '';
    return date('M d, Y', strtotime($fecha));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Podcast - Diálogo y Desarrollo Perú</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    
    <style>
        /* ============================================
           DISEÑO IDÉNTICO A ACTUALIDAD
           ============================================ */
        
        .grids-block-5 {
            background: #fafafa;
            padding: 60px 0;
        }
        
        .grids5-info {
            background: #ffffff;
            border-radius: 15px !important;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
            border: none !important;
        }
        
        .grids5-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }
        
        .grids5-info .card-image {
            display: block;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #f0f0f0;
            border-radius: 15px 15px 0 0 !important;
            flex-shrink: 0;
            position: relative;
        }
        
        .grids5-info .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            border-radius: 15px 15px 0 0;
        }
        
        .grids5-info:hover .card-image img {
            transform: scale(1.05);
        }
        
        /* Overlay con icono de podcast */
        .grids5-info .card-image .podcast-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .grids5-info:hover .card-image .podcast-overlay {
            opacity: 1;
        }
        
        .grids5-info .card-image .podcast-overlay i {
            font-size: 50px;
            color: #ffffff;
            background: #e74c3c;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(231, 76, 60, 0.5);
        }
        
        .grids5-info .card-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex: 1;
            background: #ffffff;
        }
        
        .grids5-info .card-date {
            font-size: 13px;
            color: #999;
            margin-bottom: 12px;
            font-weight: 400;
        }
        
        .grids5-info .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            line-height: 1.4;
            margin-bottom: 15px;
            flex: 1;
            min-height: 50px;
        }
        
        .grids5-info .card-title a {
            color: #1a1a2e;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .grids5-info .card-title a:hover {
            color: #e74c3c;
        }
        
        .grids5-info .card-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #e74c3c;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            margin-top: auto;
            transition: all 0.3s ease;
        }
        
        .grids5-info .card-link:hover {
            color: #c0392b;
        }
        
        .grids5-info .card-link .fa-arrow-right {
            transition: transform 0.3s ease;
        }
        
        .grids5-info .card-link:hover .fa-arrow-right {
            transform: translateX(5px);
        }
        
        /* ESPACIADO ENTRE TARJETAS */
        .grids-block-5 .row > [class*="col-"] {
            margin-bottom: 30px;
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .grids-block-5 .row {
            margin-left: -15px;
            margin-right: -15px;
        }
        
        /* Breadcrumb */
        .breadcrumb-area {
            background: #fafafa;
            padding: 40px 0;
        }
        
        .breadcrumb-area .title-big {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
    </style>
    
    






<style>
/* ============================================
   ESPACIO MODERADO ENTRE SECCIONES
   ============================================ */

/* Todas las secciones con espacio consistente */
section.w3l-homeblock3,
section.w3l-homeblock5,
section.w3l-banner,
section.w3l-team,
div.middle {
    margin-top: 40px !important;
    padding-top: 40px !important;
    padding-bottom: 40px !important;
}

/* Sección de noticias/reportajes (grid) */
div.grids-block-5 {
    padding-top: 30px !important;
    padding-bottom: 30px !important;
}

/* Breadcrumb (título de sección) */
section.breadcrumb-area {
    margin-top: 20px !important;
    margin-bottom: 0 !important;
    padding-top: 30px !important;
    padding-bottom: 15px !important;
}

/* Footer */
section.w3l-footer-29-main {
    margin-top: 40px !important;
}

/* ============================================
   BOTÓN "VER TODOS"
   ============================================ */

.btn-ver-todos-container {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    width: 100% !important;
    margin-top: 30px !important;
    margin-bottom: 20px !important;
    padding: 0 !important;
}

.btn-ver-todos {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 15px 45px !important;
    background: #e0020d !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    text-decoration: none !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    font-family: 'Cabin', sans-serif !important;
    transition: all 0.3s ease !important;
    border: none !important;
    text-align: center !important;
}

.btn-ver-todos:hover {
    background: #c0020b !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(224, 2, 13, 0.4);
}

/* ============================================
   PODCASTS - TARJETAS BLANCAS
   ============================================ */

section.w3l-homeblock3 .area-box {
    background: #ffffff !important;
    border-radius: 15px !important;
    padding: 30px 20px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s ease !important;
    text-align: center !important;
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
}

section.w3l-homeblock3 .area-box:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15) !important;
}

section.w3l-homeblock3 .area-box img {
    width: 70px !important;
    height: 70px !important;
    margin-bottom: 20px !important;
    background: #e0020d !important;
    border-radius: 50% !important;
    padding: 15px !important;
}

section.w3l-homeblock3 .area-box p {
    font-size: 14px !important;
    color: #666 !important;
    line-height: 1.6 !important;
    margin: 0 !important;
}
</style>
</head>
<body>

<!-- HEADER ORIGINAL -->
<header id="site-header" class="fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg stroke">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo.png" alt="Logo" style="height:75px;" />
            </a>
            <button class="navbar-toggler collapsed bg-gradient" type="button" data-toggle="collapse"
                data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
                <span class="navbar-toggler-icon fa icon-close fa-times"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="actualidad.php">Actualidad</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
                    <li class="nav-item active"><a class="nav-link" href="podcasts.php">Podcast</a></li>
                    <li class="nav-item"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
                    <li class="nav-item"><a class="nav-link" href="alianzas.php">Alianzas</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre D&D</a></li>
                    <li class="ml-2"><a href="contact.html" class="btn btn-style btn-outline-secondary">Contacto</a></div>
        </nav>
    </div>
</header>

<!-- SECCIÓN PODCAST -->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-big">Podcast</h2>
            </div>
        </div>
    </div>
</section>

<div class="grids-block-5">
    <div class="container">
        <div class="row">
            <?php if (count($podcasts) > 0): ?>
                <?php foreach ($podcasts as $podcast): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="grids5-info">
                            <a href="<?= htmlspecialchars($podcast['url_embed']) ?>" class="card-image" target="_blank">
                                <img src="assets/images/podcast.png" alt="<?= htmlspecialchars($podcast['titulo']) ?>" />
                                <div class="podcast-overlay">
                                    <i class="fa fa-play"></i>
                                </div>
                            </a>
                            <div class="card-content">
                                <div class="card-date"><?= fechaMes($podcast['fecha_publicacion']) ?></div>
                                <h4 class="card-title">
                                    <a href="<?= htmlspecialchars($podcast['url_embed']) ?>" target="_blank">
                                        <?= htmlspecialchars($podcast['titulo']) ?>
                                    </a>
                                </h4>
                                <a href="<?= htmlspecialchars($podcast['url_embed']) ?>" class="card-link" target="_blank">
                                    Escuchar <span class="fa fa-arrow-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No hay podcasts disponibles</p></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- FOOTER ORIGINAL -->
<section class="w3l-footer-29-main py-5" id="footer">
    <div class="footer-29 py-md-3">
        <div class="container">
            <div class="row footer-top-29">
                <div class="col-lg-6 col-md-6 footer-list-29 footer-1">
                    <h6 class="footer-title-29">Quiénes Somos</h6>
                    <p>Somos un espacio de periodismo independiente que busca visibilizar las acciones de diálogo en el país desde una mirada constructiva.</p>
                    <div class="main-social-footer-29">
                        <a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru" class="facebook"><span class="fa fa-facebook-square"></span></a>
                        <a target="_blank" href="https://www.tiktok.com/@dialogo.y.desarrollo" class="twitter"><img src="assets/images/tiktokp.png"></a>
                        <a target="_blank" href="https://www.instagram.com/dialogo.y.desarrollo/" class="instagram"><span class="fa fa-instagram"></span></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 footer-list-29 footer-2 mt-md-0 mt-5">
                    <ul>
                        <h6 class="footer-title-29">Contenido</h6>
                        <li><a href="reportajes.php">Reportajes</a></li>
                        <li><a href="podcasts.php">Podcast</a></li>
                        <li><a href="boletines.php">Boletines</a></div>
                <div class="col-lg-3 col-md-6 mt-lg-0 mt-5 footer-list-29 footer-3">
                    <div class="properties">
                        <h6 class="footer-title-29" style="display: flex; justify-content: space-between; align-items: center;">Contacto <a href="admin/login.php" class="footer-title-29" style="margin: 0; padding: 0; text-decoration: none; color: #ffffff !important;">Admin</a></h6>
                        <ul>
                            <li><a href="#url">info@dialogoydesarrollo.com.pe</a></div>
                </div>
            </div>
            <div class="bottom-copies text-center">
                <p class="copy-footer-29">© 2026 Diálogo y Desarrollo Perú. All rights reserved | Designed by <a target="_blank" href="https://www.wsperu.info/">WebSolutions</a></p>
            </div>
        </div>
    </div>
    <button onclick="topFunction()" id="movetop" title="Go to top"><span class="fa fa-angle-up"></span></button>
</section>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script>
    window.onscroll = function () { scrollFunction(); };
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("movetop").style.display = "block";
        } else {
            document.getElementById("movetop").style.display = "none";
        }
    }
    function topFunction() { document.body.scrollTop = 0; document.documentElement.scrollTop = 0; }
</script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>





















