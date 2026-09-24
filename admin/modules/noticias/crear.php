<?php
require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = trim($_POST['titulo'] ?? '');
    $link   = trim($_POST['link_externo'] ?? '');
    $fecha  = $_POST['fecha_publicacion'] ?? '';

    if (empty($titulo) || empty($fecha)) {
        $error = 'Título y fecha son obligatorios';
    } else {
        $rutaFoto = null;

        // Procesar imagen si se subió
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $subida = subirArchivo($_FILES['foto'], 'uploads/noticias', ['jpg','jpeg','png','gif','webp'], 3);
            if ($subida['success']) {
                $rutaFoto = $subida['ruta'];
            } else {
                $error = 'Error al subir imagen: ' . $subida['mensaje'];
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("
                INSERT INTO noticias
                (titulo, foto, link_externo, fecha_publicacion, usuario_id)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $titulo,
                $rutaFoto,
                $link ?: null,
                $fecha,
                $_SESSION['usuario_id']
            ]);

            header('Location: index.php?mensaje=creado');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Noticia</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/admin.css">
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

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<div class="table-container">

<div class="table-header">
<h4><i class="fas fa-bullhorn"></i> Nueva Noticia</h4>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Título</label>
<input class="form-control" name="titulo" required maxlength="255">
</div>

<div class="mb-3">
<label>Imagen destacada</label>
<input type="file" name="foto" class="form-control" accept="image/*" id="inputFoto">
<small class="text-muted">Máximo 3 MB. Formatos: JPG, PNG, GIF, WEBP</small>
<div id="preview" style="margin-top:15px; display:none;">
<img id="imgPreview" style="max-width:300px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
</div>
</div>

<div class="mb-3">
<label>Link externo</label>
<input class="form-control" name="link_externo">
</div>

<div class="mb-3">
<label>Fecha publicación</label>
<input type="date" class="form-control" name="fecha_publicacion" required value="<?= date('Y-m-d') ?>">
</div>

<button class="btn-add">
<i class="fas fa-save"></i> Guardar
</button>

<a href="index.php" class="btn btn-secondary">Cancelar</a>

</form>

</div>

</div>

<script>
document.getElementById('inputFoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    if (file.size > 3 * 1024 * 1024) {
        alert('La imagen pesa ' + (file.size / 1024 / 1024).toFixed(1) + ' MB. Máximo permitido: 3 MB');
        e.target.value = '';
        document.getElementById('preview').style.display = 'none';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('imgPreview').src = ev.target.result;
        document.getElementById('preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>

</body>
</html>