<?php
// public/noticia.php - Página para ver una noticia individual
// Ruta CORRECTA a config/database.php
require_once __DIR__ . '/../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();

if (!$noticia) {
    header('Location: index.php');
    exit;
}

if (!empty($noticia['link_externo'])) {
    header('Location: ' . $noticia['link_externo']);
    exit;
}

function fechaFormateada($fecha) {
    if (empty($fecha)) return '';
    setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
    return strftime('%d de %B, %Y', strtotime($fecha));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($noticia['titulo']) ?> - Diálogo y Desarrollo Perú</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <style>
        .noticia-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .noticia-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
        }
        .noticia-header .meta {
            font-size: 14px;
            color: #999;
            margin-top: 10px;
        }
        .noticia-header .meta i {
            margin-right: 5px;
        }
        .btn-volver {
            background: #1a1a2e;
            color: #fff;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-volver:hover {
            background: #e74c3c;
            color: #fff;
        }
    </style>
</head>
<body>

<!-- HEADER -->
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
                    <li class="nav-item"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
                    <li class="nav-item"><a class="nav-link" href="alianzas.php">Alianzas</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre D&D</a></li>
                    <li class="ml-2"><a href="contact.html" class="btn btn-style btn-outline-secondary">Contacto</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-contents">
                    <h2 class="title-big">Noticia</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="noticia-header">
                <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
                <div class="meta">
                    <i class="far fa-calendar-alt"></i> <?= fechaFormateada($noticia['fecha_publicacion']) ?>
                </div>
            </div>
            <div class="mt-4">
                <p><?= htmlspecialchars($noticia['contenido'] ?? 'Contenido de la noticia: ' . $noticia['titulo']) ?></p>
            </div>
            <a href="actualidad.php" class="btn-volver"><i class="fas fa-arrow-left"></i> Volver a Actualidad</a>
        </div>
    </div>
</div>

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
                    <ul><h6 class="footer-title-29">Contenido</h6>
                        <li><a href="reportajes.php">Reportajes</a></li>
                        <li><a href="podcasts.php">Podcast</a></li>
                        <li><a href="boletines.php">Boletines</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mt-lg-0 mt-5 footer-list-29 footer-3">
                    <div class="properties"><h6 class="footer-title-29">Contacto</h6><ul><li><a href="#url">info@dialogoydesarrollo.com.pe</a></li></ul></div>
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
