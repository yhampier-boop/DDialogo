<?php
require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$modulo_activo = 'reportajes';
$error = '';

$autores = $pdo->query("
    SELECT id, nombres, ap_paterno, ap_materno
    FROM autores
    ORDER BY nombres
")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo     = trim($_POST['titulo'] ?? '');
    $resumen    = trim($_POST['resumen_corto'] ?? '');
    $desarrollo = trim($_POST['desarrollo'] ?? '');
    $fecha      = $_POST['fecha_publicacion'] ?? '';
    $autor_id   = (int)($_POST['autor_id'] ?? 0);
    $destacado  = isset($_POST['es_destacado']) ? 1 : 0;

    if (empty($titulo) || empty($desarrollo) || empty($fecha) || $autor_id <= 0) {
        $error = 'Título, desarrollo, fecha y autor son obligatorios';
    } else {
        $rutaFoto = null;

        // Procesar imagen si se subió
        if (isset($_FILES['foto_principal']) && $_FILES['foto_principal']['error'] === UPLOAD_ERR_OK) {
            $subida = subirArchivo($_FILES['foto_principal'], 'uploads/reportajes', ['jpg','jpeg','png','gif','webp'], 3);
            if ($subida['success']) {
                $rutaFoto = $subida['ruta'];
            } else {
                $error = 'Error al subir imagen: ' . $subida['mensaje'];
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("
                INSERT INTO reportajes
                (
                    titulo,
                    resumen_corto,
                    desarrollo,
                    foto_principal,
                    fecha_publicacion,
                    es_destacado,
                    autor_id,
                    usuario_id
                )
                VALUES (?,?,?,?,?,?,?,?)
            ");

            $stmt->execute([
                $titulo,
                $resumen,
                $desarrollo,
                $rutaFoto,
                $fecha,
                $destacado,
                $autor_id,
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

<title>Nuevo Reportaje</title>

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

<h4>
<i class="fas fa-newspaper"></i>
Nuevo Reportaje
</h4>

</div>


<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>


<form method="POST" enctype="multipart/form-data">


<div class="mb-3">

<label class="form-label">
Título
</label>

<input 
type="text"
name="titulo"
class="form-control"
required>

</div>


<div class="mb-3">

<label class="form-label">
Imagen principal
</label>

<input 
type="file"
name="foto_principal"
class="form-control"
accept="image/*"
id="inputFoto">

<small class="text-muted">Máximo 3 MB. Formatos: JPG, PNG, GIF, WEBP</small>

<div id="preview" style="margin-top:15px; display:none;">
<img id="imgPreview" style="max-width:300px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
</div>

</div>


<div class="mb-3">

<label class="form-label">
Resumen corto
</label>

<textarea
name="resumen_corto"
class="form-control"
rows="3"></textarea>

</div>


<div class="mb-3">

<label class="form-label">
Desarrollo
</label>

<textarea
name="desarrollo"
class="form-control"
rows="8"
required></textarea>

</div>


<div class="mb-3">

<label class="form-label">
Fecha publicación
</label>

<input
type="date"
name="fecha_publicacion"
class="form-control"
required
value="<?= date('Y-m-d') ?>">

</div>


<div class="mb-3">

<label class="form-label">
Autor
</label>

<select name="autor_id" class="form-control" required>

<option value="">
Seleccione autor
</option>

<?php foreach($autores as $autor): ?>

<option value="<?= $autor['id'] ?>">
<?= htmlspecialchars($autor['nombres'].' '.$autor['ap_paterno'].' '.$autor['ap_materno']) ?>
</option>

<?php endforeach; ?>

</select>

</div>


<div class="form-check mb-3">

<input 
class="form-check-input"
type="checkbox"
name="es_destacado"
id="destacado">

<label class="form-check-label" for="destacado">
Marcar como destacado
</label>

</div>


<button type="submit" class="btn-add">

<i class="fas fa-save"></i>
Guardar

</button>


<a href="index.php" class="btn btn-secondary">
Cancelar
</a>


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