<?php

require_once '../../../config/database.php';

session_start();


if (!isset($_SESSION['usuario_id'])) {
header('Location: ../../login.php');
exit;
}


$id=(int)($_GET['id'] ?? 0);


$stmt=$pdo->prepare("SELECT * FROM boletines WHERE id=?");

$stmt->execute([$id]);

$boletin=$stmt->fetch();


if(!$boletin){

header('Location:index.php');

exit;

}



if($_SERVER['REQUEST_METHOD']=='POST'){


$update=$pdo->prepare("

UPDATE boletines SET

numero_boletin=?,
resumen=?,
fecha_publicacion=?

WHERE id=?

");


$update->execute([

$_POST['numero_boletin'],
$_POST['resumen'],
$_POST['fecha_publicacion'],
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

<title>Editar Boletín</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/admin.css">

</head>


<body>


<?php include '../../includes/sidebar.php'; ?>


<div class="main-content">


<div class="table-container">


<div class="table-header">


<h4>
<i class="fas fa-edit"></i>
Editar Boletín
</h4>


</div>



<form method="POST">


<div class="mb-3">

<label>Número de boletín</label>

<input 
class="form-control"
name="numero_boletin"
value="<?=htmlspecialchars($boletin['numero_boletin'])?>"
required>

</div>



<div class="mb-3">

<label>Resumen</label>

<textarea 
class="form-control"
name="resumen"><?=htmlspecialchars($boletin['resumen'])?></textarea>

</div>



<div class="mb-3">

<label>Fecha publicación</label>

<input 
type="date"
class="form-control"
name="fecha_publicacion"
value="<?=$boletin['fecha_publicacion']?>">

</div>



<button class="btn-add">

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
