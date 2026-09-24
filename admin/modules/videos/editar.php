<?php

require_once '../../../config/database.php';

session_start();


if (!isset($_SESSION['usuario_id'])) {

header('Location: ../../login.php');
exit;

}



$id=(int)($_GET['id'] ?? 0);



$stmt=$pdo->prepare("SELECT * FROM videos WHERE id=?");

$stmt->execute([$id]);

$video=$stmt->fetch();



if(!$video){

header('Location:index.php');

exit;

}



if($_SERVER['REQUEST_METHOD']=='POST'){


$update=$pdo->prepare("

UPDATE videos SET

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

<title>Editar Video</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


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

<i class="fas fa-edit"></i>

Editar Video

</h4>

</div>



<form method="POST">



<div class="mb-3">

<label>Título</label>


<input
class="form-control"
name="titulo"
value="<?=htmlspecialchars($video['titulo'])?>"
required>


</div>



<div class="mb-3">

<label>URL Embed</label>


<input
class="form-control"
name="url_embed"
value="<?=htmlspecialchars($video['url_embed'])?>"
required>


</div>



<div class="mb-3">

<label>Fecha publicación</label>


<input
type="date"
class="form-control"
name="fecha_publicacion"
value="<?=$video['fecha_publicacion']?>"
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

