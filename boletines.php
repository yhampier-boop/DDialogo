<?php
// boletines.php - Lista de boletines con preview nativo del navegador
require_once 'config/database.php';

$stmt = $pdo->query("SELECT * FROM boletines ORDER BY fecha_publicacion DESC");
$boletines = $stmt->fetchAll();

function fechaDiaMes($fecha) {
    if (empty($fecha)) return '';
    $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $f = strtotime($fecha);
    return date('d', $f) . ' de ' . $meses[date('n', $f) - 1] . ' de ' . date('Y', $f);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Boletin NTEP - Dialogo y Desarrollo Peru</title>
<link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style-starter.css">
<style>
    /* Compensar el header fijo */
    .breadcrumb-area {
        padding-top: 130px !important;
        padding-bottom: 30px !important;
        margin-top: 0 !important;
    }
    .breadcrumb-area .title-big {
        font-size: 42px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 10px 0;
    }
    .breadcrumb-area p {
        color: #999 !important;
        font-size: 16px;
        margin: 0 !important;
    }
    /* Espacio del contenedor principal */
    .container[style*="padding"] {
        padding-top: 20px !important;
    }

    /* BOLETINES GRID */
    .boletines-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .boletin-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .boletin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    }
    .pdf-preview {
        width: 100%;
        height: 400px;
        background: #f5f5f5;
        border-bottom: 1px solid #f0f0f0;
        overflow: hidden;
        position: relative;
    }
    .pdf-preview embed,
    .pdf-preview object {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }
    .pdf-preview .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 10px;
        pointer-events: none;
    }
    .pdf-preview .overlay span {
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .boletin-info {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .boletin-numero {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 8px;
    }
    .boletin-fecha {
        font-size: 14px;
        color: #999;
        margin-bottom: 20px;
    }
    .btn-leer-boletin {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 25px;
        background: #e0020d;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        margin-top: auto;
        border: none;
    }
    .btn-leer-boletin:hover {
        background: #c0020b;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(224,2,13,0.4);
    }
    .sin-pdf {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #999;
        font-size: 14px;
        text-align: center;
        padding: 20px;
    }
</style>
</head>
<body>
<header id="site-header" class="fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg stroke">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/iconos/logo.png" alt="Logo" style="height:75px;" />
            </a>
            <button class="navbar-toggler collapsed bg-gradient" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
                <span class="navbar-toggler-icon" style="display:flex;align-items:center;justify-content:center;font-size:24px;">&#9776;</span>
                <span class="navbar-toggler-icon" style="display:none;align-items:center;justify-content:center;font-size:24px;">&#10005;</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="actualidad.php">Actualidad</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
                    <li class="nav-item"><a class="nav-link" href="podcasts.php">Podcast</a></li>
                    <li class="nav-item active"><a class="nav-link" href="boletines.php">Boletin NTEP</a></li>
                    <li class="nav-item"><a class="nav-link" href="alianzas.php">Alianzas</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre D&D</a></li>
                    <li class="ml-2"><a href="contact.html" class="btn btn-style btn-outline-secondary">Contacto</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<section class="breadcrumb-area">
    <div class="container">
        <h2 class="title-big">Boletin NTEP</h2>
        <p style="color:#999; margin-top:10px;"><?= count($boletines) ?> boletin<?= count($boletines) != 1 ? 'es' : '' ?> disponible<?= count($boletines) != 1 ? 's' : '' ?></p>
    </div>
</section>

<div class="container" style="padding: 40px 15px 80px;">
    <?php if (count($boletines) > 0): ?>
        <div class="boletines-grid">
            <?php foreach ($boletines as $boletin): ?>
                <div class="boletin-card">
                    <div class="pdf-preview">
                        <?php if (!empty($boletin['archivo_pdf']) && file_exists($boletin['archivo_pdf'])): ?>
                            <embed src="<?= htmlspecialchars($boletin['archivo_pdf']) ?>#toolbar=0&navpanes=0&scrollbar=0&view=FitH" type="application/pdf">
                            <div class="overlay"><span>Vista previa</span></div>
                        <?php else: ?>
                            <div class="sin-pdf">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="#ccc" style="margin-bottom:15px;"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg>
                                Vista previa no disponible
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="boletin-info">
                        <div class="boletin-numero">Boletin <?= htmlspecialchars($boletin['numero_boletin']) ?></div>
                        <div class="boletin-fecha"><?= fechaDiaMes($boletin['fecha_publicacion']) ?></div>
                        <a href="<?= htmlspecialchars($boletin['archivo_pdf']) ?>" target="_blank" class="btn-leer-boletin">
                            Leer Boletin
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align:center; padding:60px 20px;">
            <p style="color:#999; font-size:18px;">No hay boletines disponibles</p>
        </div>
    <?php endif; ?>
</div>

<section class="w3l-footer-29-main py-5" id="footer">
    <div class="footer-29 py-md-3">
        <div class="container">
            <div class="row footer-top-29">
                <div class="col-lg-6 col-md-6 footer-list-29 footer-1">
                    <h6 class="footer-title-29">Quienes Somos</h6>
                    <p>Somos un espacio de periodismo independiente que busca visibilizar las acciones de dialogo en el pais desde una mirada constructiva.</p>
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
                        <li><a href="boletines.php">Boletines</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mt-lg-0 mt-5 footer-list-29 footer-3">
                    <div class="properties">
                        <h6 class="footer-title-29" style="display: flex; justify-content: space-between; align-items: center;">Contacto <a href="admin/login.php" class="footer-title-29" style="margin: 0; padding: 0; text-decoration: none; color: #ffffff !important;">Admin</a></h6>
                        <ul><li><a href="#url">info@dialogoydesarrollo.com.pe</a></li></ul>
                    </div>
                </div>
            </div>
            <div class="bottom-copies text-center">
                <p class="copy-footer-29">&copy; <?= date('Y') ?> Dialogo y Desarrollo Peru. All rights reserved</p>
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