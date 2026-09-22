<?php

require_once '../../../config/database.php';

session_start();


if (!isset($_SESSION['usuario_id'])) {

header('Location: ../../login.php');
exit;

}



$id=(int)($_GET['id'] ?? 0);



$stmt=$pdo->prepare("SELECT * FROM podcasts WHERE id=?");

$stmt->execute([$id]);

$podcast=$stmt->fetch();



if(!$podcast){

header('Location:index.php');

exit;

}



if($_SERVER['REQUEST_METHOD']=='POST'){


$update=$pdo->prepare("

UPDATE podcasts SET

titulo=?,
url_embed=?,
fecha_publicacion=?

WHERE id=?

");



$update->execute([

$_POST['titulo'],
$_POST['url_embed'],
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

<title>Editar Podcast</title>


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

Editar Podcast

</h4>

</div>


<form method="POST">



<div class="mb-3">

<label>Título</label>

<input 
class="form-control"
name="titulo"
value="<?=htmlspecialchars($podcast['titulo'])?>"
required>

</div>



<div class="mb-3">

<label>URL Embed</label>

<input 
class="form-control"
name="url_embed"
value="<?=htmlspecialchars($podcast['url_embed'])?>"
required>

</div>



<div class="mb-3">

<label>Fecha publicación</label>

<input 
type="date"
class="form-control"
name="fecha_publicacion"
value="<?=$podcast['fecha_publicacion']?>"
required>

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

