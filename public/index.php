<?php
// public/index.php - Página de inicio
// Ruta CORRECTA a config/database.php desde public/
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC LIMIT 6");
$noticias = $stmt->fetchAll();

function fechaMes($fecha) {
    if (empty($fecha)) return '';
    return date('M d, Y', strtotime($fecha));
}

function obtenerLink($item) {
    if (!empty($item['link_externo'])) {
        return $item['link_externo'];
    }
    return 'noticia.php?id=' . $item['id'];
}

function targetBlank($item) {
    return !empty($item['link_externo']) ? 'target="_blank"' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Diálogo y Desarrollo</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/style-starter.css">
    <style>
        .grids5-info {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            transition: all 0.3s;
            border: none !important;
        }
        .grids5-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .grids5-info .d-block {
            display: block;
            flex-shrink: 0;
            overflow: hidden;
        }
        .grids5-info .d-block img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .grids5-info .blog-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            background: #ffffff;
        }
        .grids5-info .blog-info h5 {
            font-size: 13px;
            color: #999;
            margin-bottom: 8px;
            font-weight: 400;
        }
        .grids5-info .blog-info h4 {
            flex: 1;
            margin-bottom: 10px;
        }
        .grids5-info .blog-info h4 a {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a2e;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            min-height: 44px;
        }
        .grids5-info .blog-info .btn {
            margin-top: auto;
            color: #e74c3c;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0;
            background: transparent !important;
            border: none !important;
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
                    <li class="nav-item active"><a class="nav-link" href="index.php">Inicio</a></li>
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
                    <h2 class="title-big">Noticias Recientes</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="grids-block-5 py-5">
    <section class="py-lg-4 py-md-3">
        <div class="container">
            <div class="row">
                <?php if (count($noticias) > 0): ?>
                    <?php foreach ($noticias as $i => $noticia): ?>
                        <div class="col-lg-4 col-md-6 grids5-info <?= $i > 0 ? 'mt-5' : '' ?>">
                            <a href="<?= obtenerLink($noticia) ?>" class="d-block" <?= targetBlank($noticia) ?>>
                                <?php if (!empty($noticia['foto'])): ?>
                                    <img src="<?= htmlspecialchars($noticia['foto']) ?>" alt="" class="img-fluid" />
                                <?php else: ?>
                                    <img src="assets/images/noticias/nota-facebook-21-11-25.png" alt="" class="img-fluid" />
                                <?php endif; ?>
                            </a>
                            <div class="blog-info">
                                <h5><?= fechaMes($noticia['fecha_publicacion']) ?></h5>
                                <h4><a href="<?= obtenerLink($noticia) ?>" class="d-block" <?= targetBlank($noticia) ?>><?= htmlspecialchars($noticia['titulo']) ?></a></h4>
                                <a href="<?= obtenerLink($noticia) ?>" class="btn mt-4 p-0" <?= targetBlank($noticia) ?>>Leer &rarr;</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center"><p>No hay noticias disponibles</p></div>
                <?php endif; ?>
            </div>
        </div>
    </section>
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
                        <a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru" class="facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle;"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a target="_blank" href="https://www.tiktok.com/@dialogo.y.desarrollo" class="twitter"><img src="assets/images/iconos/tiktokp.png"></a>
                        <a target="_blank" href="https://www.instagram.com/dialogo.y.desarrollo/" class="instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
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
