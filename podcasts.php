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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<style>
/* ============================================
   COMPENSAR HEADER FIJO - ESTILO BOLETIN
   ============================================ */
section.breadcrumb-area {
    padding-top: 140px !important;
    padding-bottom: 40px !important;
    margin-top: 0 !important;
    background: #fafafa !important;
}
.breadcrumb-area .container {
    padding-left: 30px !important;
    padding-right: 30px !important;
    max-width: 1200px !important;
    margin: 0 auto !important;
}
.breadcrumb-area .title-big,
.breadcrumb-area h2.title-big {
    font-size: 42px !important;
    font-weight: 700 !important;
    color: #1a1a2e !important;
    margin: 0 0 15px 0 !important;
    padding: 0 !important;
    line-height: 1.2 !important;
}
.breadcrumb-area p {
    color: #999 !important;
    font-size: 16px !important;
    margin: 0 !important;
    padding: 0 !important;
}
/* Ocultar breadcrumbs viejos si existen */
.breadcrumb-area .breadcrumb {
    display: none !important;
}
</style>
</head>
<body>

<!-- HEADER ORIGINAL -->
<header id="site-header" class="fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg stroke">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/iconos/logo.png" alt="Logo" style="height:75px;" />
            </a>
            <button class="navbar-toggler collapsed bg-gradient" type="button" data-toggle="collapse"
                data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle;"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle;"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
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
                                <img src="assets/images/podcasts/podcast.png" alt="<?= htmlspecialchars($podcast['titulo']) ?>" />
                                <div class="podcast-overlay">
                                    <span style="color: #fff; font-size: 24px; margin-left: 5px;">&#9654;</span>
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
                                    Escuchar &rarr;
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
                        <a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru" class="facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle;"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a target="_blank" href="https://www.tiktok.com/@dialogo.y.desarrollo" class="twitter"><img src="assets/images/iconos/tiktokp.png"></a>
                        <a target="_blank" href="https://www.instagram.com/dialogo.y.desarrollo/" class="instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
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
    <button onclick="topFunction()" id="movetop" title="Go to top"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" transform="rotate(-90 12 12)"/></svg></button>
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





















