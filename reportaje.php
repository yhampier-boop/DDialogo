<?php
// reportaje.php - Página de reportaje individual (dinámica)
require_once 'config/database.php';

// Obtener el ID del reportaje
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Obtener el reportaje de la base de datos
$stmt = $pdo->prepare("
    SELECT r.*, a.nombres as autor_nombre, a.ap_paterno as autor_apellido, a.nickname, a.es_nickname
    FROM reportajes r
    LEFT JOIN autores a ON r.autor_id = a.id
    WHERE r.id = ?
");
$stmt->execute([$id]);
$reportaje = $stmt->fetch();

if (!$reportaje) {
    header('Location: index.php');
    exit;
}

// Obtener últimas noticias para la barra lateral
$stmt = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC LIMIT 3");
$noticias = $stmt->fetchAll();

// Obtener últimos reportajes para la barra lateral
$stmt = $pdo->query("SELECT id, titulo FROM reportajes ORDER BY fecha_publicacion DESC LIMIT 5");
$ultimos_reportajes = $stmt->fetchAll();

function fechaFormateada($fecha) {
    if (empty($fecha)) return '';
    setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
    return strftime('%d de %B, %Y', strtotime($fecha));
}

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
    <title>DyD Perú | <?= htmlspecialchars($reportaje['titulo']) ?></title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
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
                    <li class="nav-item active"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
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

<!-- SECCIÓN REPORTAJE -->
<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-contents">
                    <h2 class="title-big">Reportajes</h2>
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="index.php">Inicio</a></li>
                            <li class="active"><a href="reportajes.php">Reportajes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="w3l-blog mt-lg-5">
    <div class="text-element-9 py-5 mt-lg-5">
        <div class="container py-lg-3">
            <div class="row grid-text-9">
                <div class="col-lg-8">
                    <div class="blog-single-post">
                        <div class="post-content">
                            <h2 class="title-single mb-3"><?= htmlspecialchars($reportaje['titulo']) ?></h2>
                        </div>
                        <div class="single-post-image mb-4 text-center">
                            <?php if (!empty($reportaje['foto_principal'])): ?>
                                <img src="<?= htmlspecialchars($reportaje['foto_principal']) ?>" class="img-fluid w-100 radius-image" alt="<?= htmlspecialchars($reportaje['titulo']) ?>" />
                            <?php else: ?>
                                <img src="assets/images/reportaje-12-08-26-p.jpg" class="img-fluid w-100 radius-image" alt="<?= htmlspecialchars($reportaje['titulo']) ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="single-post-content">
                            <blockquote class="blockquote my-5">
                                <q class="mb-3 d-block"><?= htmlspecialchars($reportaje['resumen_corto'] ?? '') ?></q>
                            </blockquote>
                            <div class="mb-4">
                                <?= nl2br(htmlspecialchars($reportaje['desarrollo'])) ?>
                            </div>
                            <?php if (!empty($reportaje['pdf_adjunto'])): ?>
                                <div class="mt-4">
                                    <a href="<?= htmlspecialchars($reportaje['pdf_adjunto']) ?>" class="btn btn-danger" target="_blank">
                                        <i class="fa fa-file-pdf"></i> Descargar PDF
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <nav class="post-navigation row mb-5 py-4">
                            <div class="post-prev col-md-6 pr-sm-5">
                                <span class="nav-title"><span class="fa fa-arrow-left mr-2"></span> <a href="reportajes.php">Reportajes</a></span>
                            </div>
                        </nav>
                    </div>
                </div>

                <!-- BARRA LATERAL - Últimas noticias -->
                <div class="col-lg-4 left-text-9 mt-lg-0 mt-5 pl-lg-4">
                    <div class="left-top-9 mt-5 pt-sm-3">
                        <h6 class="heading-small-text-9 mb-3">Últimas noticias</h6>
                        <?php foreach ($noticias as $noticia): ?>
                            <a href="<?= !empty($noticia['link_externo']) ? htmlspecialchars($noticia['link_externo']) : 'noticia.php?id=' . $noticia['id'] ?>" class="p-post d-block py-2" <?= !empty($noticia['link_externo']) ? 'target="_blank"' : '' ?>>
                                <h6 class="text-left-inner-9"><?= htmlspecialchars($noticia['titulo']) ?></h6>
                                <span class="sub-inner-text-9"><?= fechaMes($noticia['fecha_publicacion']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="categories mt-5 pt-sm-3">
                        <h6 class="heading-small-text-9">Archivos</h6>
                        <ul>
                            <?php foreach ($ultimos_reportajes as $reportaje_item): ?>
                                <li>
                                    <a href="reportaje.php?id=<?= $reportaje_item['id'] ?>"><?= htmlspecialchars($reportaje_item['titulo']) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                        <li><a href="boletines.php">Boletines</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mt-lg-0 mt-5 footer-list-29 footer-3">
                    <div class="properties">
                        <h6 class="footer-title-29" style="display: flex; justify-content: space-between; align-items: center;">Contacto <a href="admin/login.php" class="footer-title-29" style="margin: 0; padding: 0; text-decoration: none; color: #ffffff !important;">Admin</a></h6>
                        <ul>
                            <li><a href="#url">info@dialogoydesarrollo.com.pe</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bottom-copies text-center">
                <p class="copy-footer-29">© <?= date('Y') ?> Diálogo y Desarrollo Perú. All rights reserved | Designed by <a target="_blank" href="https://www.wsperu.info">WebSolutions</a></p>
            </div>
        </div>
    </div>
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-angle-up"></span>
    </button>
</section>

<!-- SCRIPTS ORIGINALES -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/theme-change.js"></script>
<script src="assets/js/lightbox-plus-jquery.min.js"></script>
<script src="assets/js/easyResponsiveTabs.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
    window.onscroll = function () { scrollFunction(); };
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("movetop").style.display = "block";
        } else {
            document.getElementById("movetop").style.display = "none";
        }
    }
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            loop: true, margin: 0, responsiveClass: true,
            responsive: {
                0: { items: 1, nav: true },
                400: { items: 2, nav: true, margin: 20 },
                768: { items: 3, nav: true, margin: 20 },
                1000: { items: 4, nav: true, loop: true, margin: 25 }
            }
        })
    });
</script>

</body>
</html>








