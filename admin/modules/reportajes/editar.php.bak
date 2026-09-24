<?php

require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location:index.php');
    exit;
}


$autores = $pdo->query("
SELECT id,nombres,ap_paterno,ap_materno
FROM autores
ORDER BY nombres
")->fetchAll();



$stmt = $pdo->prepare("
SELECT *
FROM reportajes
WHERE id = ?
");

$stmt->execute([$id]);

$reportaje = $stmt->fetch();


if (!$reportaje) {
    header('Location:index.php');
    exit;
}



if ($_SERVER['REQUEST_METHOD']=='POST') {


$titulo = $_POST['titulo'];
$resumen = $_POST['resumen_corto'];
$desarrollo = $_POST['desarrollo'];
$fecha = $_POST['fecha_publicacion'];
$autor_id = $_POST['autor_id'];

$destacado = isset($_POST['es_destacado']) ? 1 : 0;



$update = $pdo->prepare("
UPDATE reportajes SET

titulo=?,
resumen_corto=?,
desarrollo=?,
fecha_publicacion=?,
es_destacado=?,
autor_id=?

WHERE id=?

");


$update->execute([

$titulo,
$resumen,
$desarrollo,
$fecha,
$destacado,
$autor_id,
$id

]);



header('Location:index.php?mensaje=editado');
exit;


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

</head>


<body>


<?php include '../../includes/sidebar.php'; ?>


<div class="main-content">


<div class="table-container">


<div class="table-header">

<h4>

<i class="fas fa-edit"></i>

Editar Reportaje

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
value="<?= htmlspecialchars($reportaje['titulo']) ?>"
required>

</div>




<div class="mb-3">

<label class="form-label">
Resumen corto
</label>

<textarea 
name="resumen_corto"
class="form-control"
rows="3"><?= htmlspecialchars($reportaje['resumen_corto']) ?></textarea>


</div>




<div class="mb-3">

<label class="form-label">
Desarrollo
</label>


<textarea 
name="desarrollo"
class="form-control"
rows="8"
required><?= htmlspecialchars($reportaje['desarrollo']) ?></textarea>


</div>




<div class="mb-3">

<label class="form-label">
Fecha publicación
</label>


<input 
type="date"
name="fecha_publicacion"
class="form-control"
value="<?= $reportaje['fecha_publicacion'] ?>"
required>


</div>




<div class="mb-3">

<label class="form-label">
Autor
</label>


<select name="autor_id" class="form-control">


<?php foreach($autores as $autor): ?>


<option 
value="<?= $autor['id'] ?>"
<?= $autor['id']==$reportaje['autor_id']?'selected':'' ?>
>


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
<?= $reportaje['es_destacado']?'checked':'' ?>
>


<label class="form-check-label">

Destacado

</label>


</div>




<button class="btn-add">

<i class="fas fa-save"></i>

Actualizar

</button>



<a href="index.php" class="btn btn-secondary">

Cancelar

</a>



</form>


</div>


</div>


</body>

</html>


