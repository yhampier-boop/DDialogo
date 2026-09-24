<?php
require_once '../../../config/database.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha_publicacion'] ?? '';

    if (empty($fecha)) {
        $error = 'La fecha es obligatoria';
    } elseif (!isset($_FILES['archivo_pdf']) || $_FILES['archivo_pdf']['error'] !== UPLOAD_ERR_OK) {
        $error = 'Debes subir un archivo PDF';
    } else {
        $rutaPdf = null;

        // Subir PDF
        $subida = subirArchivo($_FILES['archivo_pdf'], 'uploads/boletines', ['pdf'], 15);
        if ($subida['success']) {
            $rutaPdf = $subida['ruta'];
        } else {
            $error = 'Error al subir PDF: ' . $subida['mensaje'];
        }

        if (empty($error)) {
            // Generar numero de boletin automatico
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM boletines");
            $total = $stmt->fetch()['total'] + 1;
            $numero = 'BOL-' . str_pad($total, 3, '0', STR_PAD_LEFT);

            $stmt = $pdo->prepare("INSERT INTO boletines (numero_boletin, resumen, foto_portada, archivo_pdf, fecha_publicacion, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$numero, '', null, $rutaPdf, $fecha, $_SESSION['usuario_id']]);

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
<title>Nuevo Boletin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
<?php include '../../includes/sidebar.php'; ?>
<div class="main-content">
<div class="table-container">
<div class="table-header">
<h4><i class="fas fa-file-pdf"></i> Nuevo Boletin</h4>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Archivo PDF *</label>
<input type="file" name="archivo_pdf" class="form-control" accept=".pdf,application/pdf" required>
<small class="text-muted">Maximo 15 MB. Solo PDF. La portada se generara automaticamente.</small>
</div>

<div class="mb-3">
<label>Fecha publicacion *</label>
<input type="date" class="form-control" name="fecha_publicacion" required value="<?= date('Y-m-d') ?>">
</div>

<button type="submit" class="btn-add"><i class="fas fa-save"></i> Guardar</button>
<a href="index.php" class="btn btn-secondary">Cancelar</a>

</form>
</div>
</div>
</body>
</html>