<?php
require_once '../../../config/database.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }

$autores = $pdo->query("SELECT id, nombres, ap_paterno, ap_materno FROM autores ORDER BY nombres")->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM reportajes WHERE id = ?");
$stmt->execute([$id]);
$reportaje = $stmt->fetch();
if (!$reportaje) { header('Location: index.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo     = trim($_POST['titulo'] ?? '');
    $resumen    = trim($_POST['resumen_corto'] ?? '');
    $desarrollo = trim($_POST['desarrollo'] ?? '');
    $fecha      = $_POST['fecha_publicacion'] ?? '';
    $autor_id   = (int)($_POST['autor_id'] ?? 0);
    $destacado  = isset($_POST['es_destacado']) ? 1 : 0;

    if (empty($titulo) || empty($desarrollo) || empty($fecha) || $autor_id <= 0) {
        $error = 'Titulo, desarrollo, fecha y autor son obligatorios';
    } else {
        $rutaFoto  = $reportaje['foto_principal'];
        $nuevaFoto = false;

        if (isset($_FILES['foto_principal']) && $_FILES['foto_principal']['error'] === UPLOAD_ERR_OK) {
            $subida = subirArchivo($_FILES['foto_principal'], 'uploads/reportajes', ['jpg','jpeg','png','gif','webp'], 3);
            if ($subida['success']) {
                $rutaFoto = $subida['ruta'];
                $nuevaFoto = true;
            } else {
                $error = 'Error al subir imagen: ' . $subida['mensaje'];
            }
        }

        if (isset($_POST['eliminar_foto']) && $_POST['eliminar_foto'] == '1') {
            eliminarArchivo($reportaje['foto_principal']);
            $rutaFoto = null;
            $nuevaFoto = false;
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("UPDATE reportajes SET titulo = ?, resumen_corto = ?, desarrollo = ?, foto_principal = ?, fecha_publicacion = ?, es_destacado = ?, autor_id = ? WHERE id = ?");
            $stmt->execute([$titulo, $resumen, $desarrollo, $rutaFoto, $fecha, $destacado, $autor_id, $id]);

            if ($nuevaFoto && !empty($reportaje['foto_principal']) && $reportaje['foto_principal'] !== $rutaFoto) {
                eliminarArchivo($reportaje['foto_principal']);
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
<title>Editar Reportaje</title>
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
<div class="table-header"><h4><i class="fas fa-edit"></i> Editar Reportaje</h4></div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Titulo *</label>
<input type="text" name="titulo" class="form-control" required maxlength="255" value="<?= htmlspecialchars($reportaje['titulo']) ?>">
</div>

<div class="mb-3">
<label class="form-label">Imagen principal</label>

<?php if (!empty($reportaje['foto_principal']) && file_exists(__DIR__ . '/../../../' . $reportaje['foto_principal'])): ?>
<div style="margin-bottom:15px;">
<img src="../../../<?= htmlspecialchars($reportaje['foto_principal']) ?>" style="max-width:300px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
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

<input type="file" name="foto_principal" class="form-control" accept="image/*" id="inputFoto">
<small class="text-muted">Maximo 3 MB. Deja vacio para mantener la imagen actual.</small>
<div id="preview" style="margin-top:15px; display:none;">
<img id="imgPreview" style="max-width:300px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
</div>
</div>

<div class="mb-3">
<label class="form-label">Resumen corto</label>
<textarea name="resumen_corto" class="form-control" rows="3" maxlength="500"><?= htmlspecialchars($reportaje['resumen_corto']) ?></textarea>
</div>

<div class="mb-3">
<label class="form-label">Desarrollo *</label>
<textarea name="desarrollo" class="form-control" rows="8" required><?= htmlspecialchars($reportaje['desarrollo']) ?></textarea>
</div>

<div class="mb-3">
<label class="form-label">Fecha publicacion *</label>
<input type="date" name="fecha_publicacion" class="form-control" required value="<?= htmlspecialchars($reportaje['fecha_publicacion']) ?>">
</div>

<div class="mb-3">
<label class="form-label">Autor *</label>
<select name="autor_id" class="form-control" required>
<?php foreach ($autores as $autor): ?>
<option value="<?= $autor['id'] ?>" <?= $autor['id'] == $reportaje['autor_id'] ? 'selected' : '' ?>>
<?= htmlspecialchars($autor['nombres'] . ' ' . $autor['ap_paterno'] . ' ' . $autor['ap_materno']) ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-check mb-3">
<input class="form-check-input" type="checkbox" name="es_destacado" id="destacado" <?= $reportaje['es_destacado'] ? 'checked' : '' ?>>
<label class="form-check-label" for="destacado">Marcar como destacado</label>
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