<?php

require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD']=='POST') {


$numero = $_POST['numero_boletin'];
$resumen = $_POST['resumen'];
$fecha = $_POST['fecha_publicacion'];


$stmt=$pdo->prepare("
INSERT INTO boletines
(
numero_boletin,
resumen,
fecha_publicacion,
usuario_id
)
VALUES (?,?,?,?)
");


$stmt->execute([
$numero,
$resumen,
$fecha,
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

<title>Nuevo Boletín</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/admin.css">

</head>


<body>


<?php include '../../includes/sidebar.php'; ?>


<div class="main-content">


<div class="table-container">


<div class="table-header">

<h4>
<i class="fas fa-file"></i>
Nuevo Boletín
</h4>

</div>


<form method="POST">


<div class="mb-3">

<label>Número de boletín</label>

<input 
class="form-control"
name="numero_boletin"
required>

</div>



<div class="mb-3">

<label>Resumen</label>

<textarea 
class="form-control"
name="resumen"></textarea>

</div>



<div class="mb-3">

<label>Fecha publicación</label>

<input 
type="date"
class="form-control"
name="fecha_publicacion"
required>

</div>



<button class="btn-add">

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
