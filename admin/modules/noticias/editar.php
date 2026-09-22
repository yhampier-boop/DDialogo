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


$stmt = $pdo->prepare("
SELECT *
FROM noticias
WHERE id=?
");

$stmt->execute([$id]);

$noticia = $stmt->fetch();


if (!$noticia) {
    header('Location:index.php');
    exit;
}



if ($_SERVER['REQUEST_METHOD']=='POST') {


$titulo = $_POST['titulo'];

$link = $_POST['link_externo'];

$fecha = $_POST['fecha_publicacion'];



$update = $pdo->prepare("
UPDATE noticias SET

titulo=?,
link_externo=?,
fecha_publicacion=?

WHERE id=?

");


$update->execute([

$titulo,
$link,
$fecha,
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

<title>Editar Noticia</title>


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
Editar Noticia
</h4>

</div>



<form method="POST">


<div class="mb-3">

<label>Título</label>

<input 
type="text"
name="titulo"
class="form-control"
value="<?= htmlspecialchars($noticia['titulo']) ?>"
required>

</div>



<div class="mb-3">

<label>Link externo</label>

<input 
type="text"
name="link_externo"
class="form-control"
value="<?= htmlspecialchars($noticia['link_externo']) ?>">

</div>



<div class="mb-3">

<label>Fecha publicación</label>

<input 
type="date"
name="fecha_publicacion"
class="form-control"
value="<?= $noticia['fecha_publicacion'] ?>"
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


