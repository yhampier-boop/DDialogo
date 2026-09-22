<?php
require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$modulo_activo = 'reportajes';

$autores = $pdo->query("
    SELECT id,nombres,ap_paterno,ap_materno
    FROM autores
    ORDER BY nombres
")->fetchAll();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen_corto'];
    $desarrollo = $_POST['desarrollo'];
    $fecha = $_POST['fecha_publicacion'];
    $autor_id = $_POST['autor_id'];
    $destacado = isset($_POST['es_destacado']) ? 1 : 0;


    $stmt = $pdo->prepare("
        INSERT INTO reportajes
        (
        titulo,
        resumen_corto,
        desarrollo,
        fecha_publicacion,
        es_destacado,
        autor_id,
        usuario_id
        )
        VALUES (?,?,?,?,?,?,?)
    ");


    $stmt->execute([
        $titulo,
        $resumen,
        $desarrollo,
        $fecha,
        $destacado,
        $autor_id,
        $_SESSION['usuario_id']
    ]);


    header('Location:index.php?mensaje=creado');
    exit;
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



<form method="POST">


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
required>

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

<?= htmlspecialchars(
$autor['nombres'].' '.$autor['ap_paterno'].' '.$autor['ap_materno']
) ?>

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


</body>

</html>

