<?php
// public/actualidad.php - Actualidad (Noticias)
// Ruta CORRECTA a config/database.php
require_once __DIR__ . '/../config/database.php';

// Obtener todas las noticias
$stmt = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC");
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
    <title>Actualidad - Diálogo y Desarrollo Perú</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
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
        .grids5-info .d-block img:hover {
            transform: scale(1.03);
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
        .grids5-info .blog-info h4 a:hover {
            color: #e74c3c;
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
        .grids5-info .blog-info .btn:hover {
            color: #c0392b;
        }
        .grids5-info .blog-info .btn .fa-arrow-right {
            transition: transform 0.3s;
        }
        .grids5-info .blog-info .btn:hover .fa-arrow-right {
            transform: translateX(5px);
        }
        .grids5-info,
        .grids5-info .blog-info,
        .grids5-info .d-block,
        .grids5-info img {
            border: none !important;
            outline: none !important;
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
                    <li class="nav-item active"><a class="nav-link" href="actualidad.php">Actualidad</a></li>
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

<!-- SECCIÓN ACTUALIDAD -->
<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-contents">
                    <h2 class="title-big">Actualidad</h2>
                    <p>Las noticias más recientes sobre minería, desarrollo y recursos naturales en el Perú</p>
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
                                    <?php if (strpos($noticia['foto'], 'uploads/') === 0): ?>
                                        <img src="../<?= htmlspecialchars($noticia['foto']) ?>" alt="" class="img-fluid" />
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($noticia['foto']) ?>" alt="" class="img-fluid" />
                                    <?php endif; ?>
                                <?php else: ?>
                                    <img src="assets/images/nota-facebook-21-11-25.png" alt="" class="img-fluid" />
                                <?php endif; ?>
                            </a>
                            <div class="blog-info">
                                <h5><?= fechaMes($noticia['fecha_publicacion']) ?></h5>
                                <h4>
                                    <a href="<?= obtenerLink($noticia) ?>" class="d-block" <?= targetBlank($noticia) ?>>
                                        <?= htmlspecialchars($noticia['titulo']) ?>
                                    </a>
                                </h4>
                                <a href="<?= obtenerLink($noticia) ?>" class="btn mt-4 p-0" <?= targetBlank($noticia) ?>>
                                    Leer <span class="fa fa-arrow-right"></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center"><p>No hay noticias disponibles</p></div>
                <?php endif; ?>
            </div>
            <div class="pagination"><ul><li><a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru">Ver todos</a></li></ul></div>
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
