<?php
require_once '../../../config/database.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM boletines WHERE id = ?");
$stmt->execute([$id]);
$boletin = $stmt->fetch();
if (!$boletin) { header('Location: index.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha_publicacion'] ?? '';

    if (empty($fecha)) {
        $error = 'La fecha es obligatoria';
    } else {
        $rutaPdf = $boletin['archivo_pdf'];

        // Subir nuevo PDF si se selecciono
        if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] === UPLOAD_ERR_OK) {
            $subida = subirArchivo($_FILES['archivo_pdf'], 'uploads/boletines', ['pdf'], 15);
            if ($subida['success']) {
                if (!empty($boletin['archivo_pdf'])) eliminarArchivo($boletin['archivo_pdf']);
                $rutaPdf = $subida['ruta'];
            } else {
                $error = 'Error al subir PDF: ' . $subida['mensaje'];
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("UPDATE boletines SET archivo_pdf = ?, fecha_publicacion = ? WHERE id = ?");
            $stmt->execute([$rutaPdf, $fecha, $id]);
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
<title>Editar Boletin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
<?php include '../../includes/sidebar.php'; ?>
<div class="main-content">
<div class="table-container">
<div class="table-header">
<h4><i class="fas fa-edit"></i> Editar Boletin <?= htmlspecialchars($boletin['numero_boletin']) ?></h4>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>PDF actual</label>
<?php if (!empty($boletin['archivo_pdf']) && file_exists(__DIR__ . '/../../../' . $boletin['archivo_pdf'])): ?>
<div style="padding:10px; background:#f9f9f9; border-radius:8px; margin-bottom:10px;">
<i class="fas fa-file-pdf" style="color:#e0020d;"></i>
<a href="../../../<?= htmlspecialchars($boletin['archivo_pdf']) ?>" target="_blank">Ver PDF actual</a>
</div>
<?php else: ?>
<p style="color:#999; font-style:italic;">Sin PDF</p>
<?php endif; ?>
<input type="file" name="archivo_pdf" class="form-control" accept=".pdf,application/pdf">
<small class="text-muted">Deja vacio para mantener el actual. Maximo 15 MB.</small>
</div>

<div class="mb-3">
<label>Fecha publicacion *</label>
<input type="date" class="form-control" name="fecha_publicacion" required value="<?= htmlspecialchars($boletin['fecha_publicacion']) ?>">
</div>

<button type="submit" class="btn-add"><i class="fas fa-save"></i> Actualizar</button>
<a href="index.php" class="btn btn-secondary">Cancelar</a>

</form>
</div>
</div>
</body>
</html>