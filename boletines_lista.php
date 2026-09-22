<?php
// boletines_lista.php - Lista completa de boletines
require_once 'config/database.php';

$stmt = $pdo->query("SELECT * FROM boletines ORDER BY fecha_publicacion DESC");
$boletines = $stmt->fetchAll();

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
    <title>Todos los Boletines - Diálogo y Desarrollo Perú</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    
    <style>
        .boletin-card {
            background: #ffffff;
            border-radius: 15px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
            border: none !important;
            padding: 30px 25px;
            text-align: center;
        }
        .boletin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }
        .boletin-card .boletin-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: #e74c3c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 28px;
        }
        .boletin-card .boletin-numero {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .boletin-card .boletin-resumen {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            flex: 1;
            line-height: 1.5;
        }
        .boletin-card .boletin-date {
            font-size: 13px;
            color: #999;
            margin-bottom: 20px;
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
                    <li class="nav-item"><a class="nav-link" href="podcasts.php">Podcast</a></li>
                    <li class="nav-item active"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
                    <li class="nav-item"><a class="nav-link" href="alianzas.php">Alianzas</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre D&D</a></li>
                    <li class="ml-2"><a href="contact.html" class="btn btn-style btn-outline-secondary">Contacto</a></div>
        </nav>
    </div>
</header>

<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-contents">
                    <h2 class="title-big">Todos los Boletines</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="w3l-homeblock3 py-5" style="margin-top: 30px;">
    <div class="container py-lg-5 py-md-4">
        <div class="row">
            <?php if (count($boletines) > 0): ?>
                <?php foreach ($boletines as $boletin): ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="boletin-card">
                            <div class="boletin-icon">
                                <i class="fa fa-file-pdf"></i>
                            </div>
                            <div class="boletin-numero">Boletín <?= htmlspecialchars($boletin['numero_boletin']) ?></div>
                            <?php if (!empty($boletin['resumen'])): ?>
                                <div class="boletin-resumen"><?= htmlspecialchars(substr($boletin['resumen'], 0, 100)) ?>...</div>
                            <?php endif; ?>
                            <div class="boletin-date">
                                <i class="far fa-calendar-alt"></i> <?= fechaMes($boletin['fecha_publicacion']) ?>
                            </div>
                            <?php if (!empty($boletin['archivo_pdf'])): ?>
                                <a href="<?= htmlspecialchars($boletin['archivo_pdf']) ?>" class="btn btn-style btn-primary" target="_blank">
                                    <i class="fa fa-download"></i> Descargar PDF
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No hay boletines disponibles</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- FOOTER -->
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





















