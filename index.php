<?php
// index.php - Página de inicio con reportaje destacado
require_once 'config/database.php';

// Obtener el reportaje MÁS RECIENTE (destacado)
$stmt = $pdo->query("SELECT * FROM reportajes ORDER BY fecha_publicacion DESC LIMIT 1");
$reportaje_destacado = $stmt->fetch();

// Obtener los siguientes reportajes
$stmt = $pdo->query("SELECT * FROM reportajes ORDER BY fecha_publicacion DESC LIMIT 3 OFFSET 1");
$reportajes = $stmt->fetchAll();

// Obtener noticias
$stmt = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC LIMIT 6");
$noticias = $stmt->fetchAll();

// Obtener boletines
$stmt = $pdo->query("SELECT * FROM boletines ORDER BY fecha_publicacion DESC LIMIT 1");
$boletin_destacado = $stmt->fetch();

// Obtener podcasts
$stmt = $pdo->query("SELECT * FROM podcasts ORDER BY fecha_publicacion DESC LIMIT 4");
$podcasts = $stmt->fetchAll();

// Obtener VIDEOS de la base de datos
$stmt = $pdo->query("SELECT * FROM videos ORDER BY fecha_publicacion DESC LIMIT 8");



$videos = $stmt->fetchAll();



function fechaMes($fecha) {
    if (empty($fecha)) return '';
    return date('M d, Y', strtotime($fecha));
}

function fechaDiaMes($fecha) {
    if (empty($fecha)) return '';
    setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
    return strftime('%d de %B', strtotime($fecha));
}

function obtenerImagenReportaje($item) {
    if (!empty($item['foto_principal'])) {
        return $item['foto_principal'];
    }
    return 'assets/images/reportajes/reportaje-18-08-26.jpg';
}

function obtenerImagenNoticia($item) {
    if (!empty($item['foto'])) {
        return $item['foto'];
    }
    return 'assets/images/noticias/nota-facebook-21-11-25.png';
}

function obtenerLinkNoticia($item) {
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
    <title>DDP Noticias - Diálogo y Desarrollo Perú</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/style-starter.css">
    
    <style>
        /* ============================================
           REPORTAJE DESTACADO GRANDE
           ============================================ */
        
        .reportaje-destacado {
            background: #fafafa;
            padding: 60px 0;
        }
        
        .reportaje-destacado .imagen-destacada {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        
        .reportaje-destacado .imagen-destacada img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 15px;
        }
        
        .reportaje-destacado .contenido-destacado {
            padding: 20px 0 20px 40px;
        }
        
        .reportaje-destacado .fecha-destacada {
            font-size: 16px;
            color: #999;
            margin-bottom: 15px;
            font-weight: 400;
        }
        
        .reportaje-destacado .titulo-destacado {
            font-size: 36px;
            font-weight: 700;
            color: #e74c3c;
            line-height: 1.2;
            margin-bottom: 25px;
        }
        
        .reportaje-destacado .titulo-destacado a {
            color: #e74c3c;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .reportaje-destacado .titulo-destacado a:hover {
            color: #c0392b;
        }
        
        .reportaje-destacado .resumen-destacado {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .reportaje-destacado .btn-leer-destacado {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #1a1a2e;
            font-weight: 600;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .reportaje-destacado .btn-leer-destacado:hover {
            color: #e74c3c;
        }
        
        .reportaje-destacado .btn-leer-destacado .fa-arrow-right {
            transition: transform 0.3s ease;
        }
        
        .reportaje-destacado .btn-leer-destacado:hover .fa-arrow-right {
            transform: translateX(5px);
        }
        
        /* ============================================
           TARJETAS DE REPORTAJES
           ============================================ */
        
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
        }
        
        .grids5-info .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .grids5-info:hover .card-image img {
            transform: scale(1.05);
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
        
        /* ESPACIADO */
        .grids-block-5 .row > [class*="col-"] {
            margin-bottom: 30px;
            padding-left: 15px;
            padding-right: 15px;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .reportaje-destacado .contenido-destacado {
                padding: 20px 0 0 0;
            }
            .reportaje-destacado .titulo-destacado {
                font-size: 24px;
            }
            .reportaje-destacado .resumen-destacado {
                font-size: 16px;
            }
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
                    <li class="nav-item active"><a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="actualidad.php">Actualidad</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
                    <li class="nav-item"><a class="nav-link" href="podcasts.php">Podcast</a></li>
                    <li class="nav-item"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
                    <li class="nav-item"><a class="nav-link" href="alianzas.php">Alianzas</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre D&D</a></li>
                    <li class="ml-2"><a href="contact.html" class="btn btn-style btn-outline-secondary">Contacto</a></div>
        </nav>
    </div>
</header>

<!-- SECCIÓN REPORTAJE DESTACADO -->
<?php if ($reportaje_destacado): ?>
<section class="reportaje-destacado">
    <div class="container">
        <div class="row align-items-center">
            <!-- Imagen del reportaje -->
            <div class="col-lg-7">
                <div class="imagen-destacada">
                    <a href="reportaje.php?id=<?= $reportaje_destacado['id'] ?>">
                        <img src="<?= htmlspecialchars(obtenerImagenReportaje($reportaje_destacado)) ?>" alt="<?= htmlspecialchars($reportaje_destacado['titulo']) ?>" />
                    </a>
                </div>
            </div>
            
            <!-- Contenido del reportaje -->
            <div class="col-lg-5">
                <div class="contenido-destacado">
                    <div class="fecha-destacada"><?= fechaMes($reportaje_destacado['fecha_publicacion']) ?></div>
                    <h2 class="titulo-destacado">
                        <a href="reportaje.php?id=<?= $reportaje_destacado['id'] ?>">
                            <?= htmlspecialchars($reportaje_destacado['titulo']) ?>
                        </a>
                    </h2>
                    <?php if (!empty($reportaje_destacado['resumen_corto'])): ?>
                        <p class="resumen-destacado"><?= htmlspecialchars($reportaje_destacado['resumen_corto']) ?></p>
                    <?php elseif (!empty($reportaje_destacado['desarrollo'])): ?>
                        <p class="resumen-destacado"><?= htmlspecialchars(substr($reportaje_destacado['desarrollo'], 0, 250)) ?>...</p>
                    <?php endif; ?>
                    <a href="reportaje.php?id=<?= $reportaje_destacado['id'] ?>" class="btn-leer-destacado">
                        Leer &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- SECCIÓN MÁS REPORTAJES -->
<?php if (count($reportajes) > 0): ?>
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-big">Más Reportajes</h2>
            </div>
        </div>
    </div>
</section>

<div class="grids-block-5">
    <div class="container">
        <div class="row">
            <?php foreach ($reportajes as $reportaje): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="grids5-info">
                        <a href="reportaje.php?id=<?= $reportaje['id'] ?>" class="card-image">
                            <img src="<?= htmlspecialchars(obtenerImagenReportaje($reportaje)) ?>" alt="<?= htmlspecialchars($reportaje['titulo']) ?>" />
                        </a>
                        <div class="card-content">
                            <div class="card-date"><?= fechaMes($reportaje['fecha_publicacion']) ?></div>
                            <h4 class="card-title">
                                <a href="reportaje.php?id=<?= $reportaje['id'] ?>">
                                    <?= htmlspecialchars($reportaje['titulo']) ?>
                                </a>
                            </h4>
                            <a href="reportaje.php?id=<?= $reportaje['id'] ?>" class="card-link">
                                Leer &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination text-center"><a href="reportajes.php" class="btn-ver-todos">Ver Todos</a></div>
    </div>
</div>
<?php endif; ?>

<!-- SECCIÓN NOTICIAS -->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-big">Noticias Recientes</h2>
                <a class="anchor" id="actualidad"></a>
            </div>
        </div>
    </div>
</section>

<div class="grids-block-5">
    <div class="container">
        <div class="row">
            <?php if (count($noticias) > 0): ?>
                <?php foreach ($noticias as $noticia): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="grids5-info">
                            <a href="<?= obtenerLinkNoticia($noticia) ?>" class="card-image" <?= targetBlank($noticia) ?>>
                                <img src="<?= htmlspecialchars(obtenerImagenNoticia($noticia)) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>" />
                            </a>
                            <div class="card-content">
                                <div class="card-date"><?= fechaMes($noticia['fecha_publicacion']) ?></div>
                                <h4 class="card-title">
                                    <a href="<?= obtenerLinkNoticia($noticia) ?>" <?= targetBlank($noticia) ?>>
                                        <?= htmlspecialchars($noticia['titulo']) ?>
                                    </a>
                                </h4>
                                <a href="<?= obtenerLinkNoticia($noticia) ?>" class="card-link" <?= targetBlank($noticia) ?>>
                                    Leer &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No hay noticias disponibles</p></div>
            <?php endif; ?>
        </div>
        <div class="pagination text-center"><a href="actualidad.php" class="btn-ver-todos">Ver Todas Las Noticias</a></div>
    </div>
</div>

<!-- SECCIÓN BOLETÍN -->
<?php if ($boletin_destacado): ?>
<section class="w3l-homeblock5 py-0" style="margin-top: 30px;">
    <div class="container py-lg-5 py-4">
        <div class="row">
            <div class="col-lg-8 align-self">
                <h3 class="title-big mb-4">Boletín NTEP Año <?= date('Y', strtotime($boletin_destacado['fecha_publicacion'])) ?></h3>
                <?php if (!empty($boletin_destacado['resumen'])): ?>
                    <?php 
                    $resumenes = explode("\n", $boletin_destacado['resumen']);
                    foreach ($resumenes as $resumen_item): 
                        if (trim($resumen_item)): 
                    ?>
                        <p class="">- <?= htmlspecialchars(trim($resumen_item)) ?></p>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                <?php endif; ?>
                <div class="row mt-sm-4 mt-2 px-3">
                    <div class="col-6 p-0">
                        <span>Nº <?= htmlspecialchars(str_replace('BOL-', '', $boletin_destacado['numero_boletin'])) ?></span>
                        <h4><?= fechaDiaMes($boletin_destacado['fecha_publicacion']) ?></h4>
                    </div>
                    <div class="col-6 p-0">
                        <?php if (!empty($boletin_destacado['archivo_pdf'])): ?>
                            <span>
                                <a target="_blank" href="<?= htmlspecialchars($boletin_destacado['archivo_pdf']) ?>" class="facebook">
                                    &darr;
                                </a>
                            </span>
                            <h4>Ver Boletín</h4>
                        <?php endif; ?>
                    </div>
                    <center><a href="boletines.php" class="btn-ver-todos">Ver Todos</a></center>
                </div>
            </div>
            <div class="col-lg-4 mt-lg-0 mt-4">
                <?php if (!empty($boletin_destacado['foto_portada'])): ?>
                    <img src="<?= htmlspecialchars($boletin_destacado['foto_portada']) ?>" class="img-fluid radius-image" alt="Boletín">
                <?php else: ?>
                    <img src="assets/images/boletines/boletin-ntep-45.png" class="img-fluid radius-image" alt="Boletín NTEP">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- SECCIÓN PODCAST -->
<section class="w3l-homeblock3 py-5" style="margin-top: 30px;">
    <div class="container py-lg-5 py-md-4">
        <h3 class="title-big mb-5 text-center">Podcast</h3>
        <div class="row">
            <?php if (count($podcasts) > 0): ?>
                <?php foreach ($podcasts as $i => $podcast): ?>
                    <div class="col-lg-3 col-sm-6 <?= $i > 0 ? 'mt-5 mt-lg-0' : '' ?>">
                        <div class="area-box">
                            <img src="assets/images/podcasts/podcast.png">
                            <p><?= htmlspecialchars($podcast['titulo']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>No hay podcasts disponibles</p></div>
            <?php endif; ?>
        </div>
        <center><a href="podcasts.php" class="btn-ver-todos">Ver Todos</a></center>
    </div>
</section>


<!-- SECCIÓN VIDEOS -->
<section class="w3l-team" id="team">
    <div class="teams1 py-5 mb-3">
        <div class="container py-lg-3 pb-lg-5 pb-4">
            <div class="teams1-content">
                <h3 class="title-big text-center mb-5">Videos</h3>
                <?php if (count($videos) > 0): ?>
                    <div class="row justify-content-center">
                        <?php foreach ($videos as $video): ?>
                            <?php
                            $url_video = $video['url_embed'];
                            $video_id = '';
                            if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url_video, $m)) {
                                $video_id = $m[1];
                            } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url_video, $m)) {
                                $video_id = $m[1];
                            } elseif (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url_video, $m)) {
                                $video_id = $m[1];
                            }
                            $imagen_video = $video_id ? "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg" : "assets/images/videos/video.jpg";
                            ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="video-card" data-video-id="<?= htmlspecialchars($video_id) ?>" data-video-titulo="<?= htmlspecialchars($video['titulo']) ?>" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column; cursor: pointer;">
                                    <div class="video-thumb" style="position: relative; height: 200px; overflow: hidden; background: #000;">
                                        <img src="<?= $imagen_video ?>" alt="<?= htmlspecialchars($video['titulo']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s;" onerror="this.src='assets/images/videos/video.jpg'" />
                                        <div class="play-btn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 70px; height: 70px; background: #e0020d; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 20px rgba(224,2,13,0.5); transition: transform 0.3s;">
                                            <span style="color: #fff; font-size: 28px; margin-left: 5px;">&#9654;</span>
                                        </div>
                                    </div>
                                    <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                                        <h4 style="font-size: 16px; font-weight: 600; color: #1a1a2e; line-height: 1.4; margin-bottom: 10px; flex: 1;"><?= htmlspecialchars($video['titulo']) ?></h4>
                                        <small style="color: #999; font-size: 13px;"><?= fechaMes($video['fecha_publicacion']) ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center"><p>No hay videos disponibles</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- MODAL DE VIDEO -->
<div id="videoModal" style="display: none; position: fixed; inset: 0; z-index: 9999; align-items: center; justify-content: center;">
    <div id="videoModalBackdrop" style="position: absolute; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"></div>
    <div style="position: relative; z-index: 1; width: 90%; max-width: 1100px; padding: 20px;">
        <button id="videoModalClose" title="Cerrar (Esc)" style="position: absolute; top: 10px; right: 10px; z-index: 10; width: 45px; height: 45px; background: #e0020d; color: #fff; border: none; border-radius: 50%; font-size: 22px; cursor: pointer; box-shadow: 0 4px 15px rgba(224,2,13,0.6); transition: transform 0.2s; display: flex; align-items: center; justify-content: center; line-height: 1;">✕</button>
        <h3 id="videoModalTitle" style="color: #fff; margin-bottom: 15px; font-size: 20px; text-align: center;"></h3>
        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); background: #000;">
            <iframe id="videoModalFrame" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>

<style>
.video-card:hover .video-thumb img { transform: scale(1.05); }
.video-card:hover .play-btn { transform: translate(-50%, -50%) scale(1.15); }
body.video-modal-open { overflow: hidden; }
</style>

<script>
(function() {
    const modal = document.getElementById('videoModal');
    const backdrop = document.getElementById('videoModalBackdrop');
    const closeBtn = document.getElementById('videoModalClose');
    const frame = document.getElementById('videoModalFrame');
    const title = document.getElementById('videoModalTitle');
    function openModal(videoId, videoTitulo) {
        if (!videoId) { alert('Este video no tiene un ID de YouTube valido'); return; }
        frame.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0';
        title.textContent = videoTitulo;
        modal.style.display = 'flex';
        document.body.classList.add('video-modal-open');
    }
    function closeModal() {
        frame.src = '';
        modal.style.display = 'none';
        document.body.classList.remove('video-modal-open');
    }
    document.querySelectorAll('.video-card').forEach(function(card) {
        card.addEventListener('click', function() {
            openModal(this.getAttribute('data-video-id'), this.getAttribute('data-video-titulo'));
        });
    });
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') closeModal();
    });
})();
</script>

<!-- REDES SOCIALES -->
<div class="middle py-5" style="margin-top: 30px;">
    <div class="container py-xl-5 py-lg-3">
        <div class="welcome-left text-center py-md-5 py-3">
            <h3 class="title-big">Síguenos en nuestras Redes Sociales</h3>
            <div class="main-social-footer-29">
                <a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru" class="facebook"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; display:inline-block;"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg></a>
                <a target="_blank" href="https://www.tiktok.com/@dialogo.y.desarrollo" class="twitter"><img src="assets/images/iconos/tiktokg.png"></a>
                <a target="_blank" href="https://www.instagram.com/dialogo.y.desarrollo/" class="instagram"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; display:inline-block;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
            </div>
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
                        <h6 class="footer-title-29">Contacto</h6>
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
<script src="assets/js/theme-change.js"></script>
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





















