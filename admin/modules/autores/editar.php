<?php

require_once '../../../config/database.php';

session_start();


if (!isset($_SESSION['usuario_id'])) {

header('Location: ../../login.php');
exit;

}



$id=(int)($_GET['id'] ?? 0);



$stmt=$pdo->prepare("SELECT * FROM autores WHERE id=?");

$stmt->execute([$id]);

$autor=$stmt->fetch();



if(!$autor){

header('Location:index.php');

exit;

}




if($_SERVER['REQUEST_METHOD']=='POST'){



$update=$pdo->prepare("

UPDATE autores SET

nombres=?,
ap_paterno=?,
ap_materno=?,
nickname=?,
es_nickname=?

WHERE id=?

");



$update->execute([

$_POST['nombres'],
$_POST['ap_paterno'],
$_POST['ap_materno'],
$_POST['nickname'],
isset($_POST['es_nickname']) ? 1 : 0,
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

<title>Editar Autor</title>


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

Editar Autor

</h4>


</div>



<form method="POST">



<div class="mb-3">

<label>Nombres</label>

<input
class="form-control"
name="nombres"
value="<?=htmlspecialchars($autor['nombres'])?>"
required>

</div>



<div class="mb-3">

<label>Apellido paterno</label>

<input
class="form-control"
name="ap_paterno"
value="<?=htmlspecialchars($autor['ap_paterno'])?>">

</div>



<div class="mb-3">

<label>Apellido materno</label>

<input
class="form-control"
name="ap_materno"
value="<?=htmlspecialchars($autor['ap_materno'])?>">

</div>



<div class="mb-3">

<label>Nickname</label>

<input
class="form-control"
name="nickname"
value="<?=htmlspecialchars($autor['nickname'])?>">

</div>



<div class="form-check mb-3">

<input
type="checkbox"
class="form-check-input"
name="es_nickname"
<?= $autor['es_nickname'] ? 'checked' : '' ?>
>


<label class="form-check-label">

Usa nickname

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
