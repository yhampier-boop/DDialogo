<?php
require_once '../../../config/database.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();
if (!$noticia) { header('Location: index.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $link   = trim($_POST['link_externo'] ?? '');
    $fecha  = $_POST['fecha_publicacion'] ?? '';

    if (empty($titulo) || empty($fecha)) {
        $error = 'Titulo y fecha son obligatorios';
    } else {
        $rutaFoto  = $noticia['foto'];
        $nuevaFoto = false;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $subida = subirArchivo($_FILES['foto'], 'uploads/noticias', ['jpg','jpeg','png','gif','webp'], 3);
            if ($subida['success']) {
                $rutaFoto = $subida['ruta'];
                $nuevaFoto = true;
            } else {
                $error = 'Error al subir imagen: ' . $subida['mensaje'];
            }
        }

        if (isset($_POST['eliminar_foto']) && $_POST['eliminar_foto'] == '1') {
            eliminarArchivo($noticia['foto']);
            $rutaFoto = null;
            $nuevaFoto = false;
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("UPDATE noticias SET titulo = ?, foto = ?, link_externo = ?, fecha_publicacion = ? WHERE id = ?");
            $stmt->execute([$titulo, $rutaFoto, $link ?: null, $fecha, $id]);

            if ($nuevaFoto && !empty($noticia['foto']) && $noticia['foto'] !== $rutaFoto) {
                eliminarArchivo($noticia['foto']);
            }

            header('Location: index.php?mensaje=editado');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Noticia</title>
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
<div class="table-header"><h4><i class="fas fa-edit"></i> Editar Noticia</h4></div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Titulo *</label>
<input type="text" name="titulo" class="form-control" required maxlength="255" value="<?= htmlspecialchars($noticia['titulo']) ?>">
</div>

<div class="mb-3">
<label class="form-label">Imagen destacada</label>

<?php if (!empty($noticia['foto']) && file_exists(__DIR__ . '/../../../' . $noticia['foto'])): ?>
<div style="margin-bottom:15px;">
<img src="../../../<?= htmlspecialchars($noticia['foto']) ?>" style="max-width:300px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
<div class="form-check" style="margin-top:8px;">
<input type="checkbox" name="eliminar_foto" value="1" id="eliminarFoto" class="form-check-input">
<label for="eliminarFoto" class="form-check-label" style="color:#e0020d;">
<i class="fas fa-trash"></i> Eliminar imagen actual
</label>
</div>
</div>
<?php else: ?>
<p style="color:#999; font-style:italic;">Sin imagen actual</p>
<?php endif; ?>

<input type="file" name="foto" class="form-control" accept="image/*" id="inputFoto">
<small class="text-muted">Maximo 3 MB. Deja vacio para mantener la imagen actual.</small>
<div id="preview" style="margin-top:15px; display:none;">
<img id="imgPreview" style="max-width:300px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
</div>
</div>

<div class="mb-3">
<label class="form-label">Link externo</label>
<input type="url" name="link_externo" class="form-control" value="<?= htmlspecialchars($noticia['link_externo'] ?? '') ?>">
</div>

<div class="mb-3">
<label class="form-label">Fecha publicacion *</label>
<input type="date" name="fecha_publicacion" class="form-control" required value="<?= htmlspecialchars($noticia['fecha_publicacion']) ?>">
</div>

<button type="submit" class="btn-add"><i class="fas fa-save"></i> Actualizar</button>
<a href="index.php" class="btn btn-secondary">Cancelar</a>

</form>
</div>
</div>

<script>
document.getElementById('inputFoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    if (file.size > 3 * 1024 * 1024) {
        alert('La imagen pesa ' + (file.size / 1024 / 1024).toFixed(1) + ' MB. Maximo: 3 MB');
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