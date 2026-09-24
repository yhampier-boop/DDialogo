<?php

require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD']=='POST') {


    $titulo = $_POST['titulo'];
    $url = $_POST['url_embed'];
    $fecha = $_POST['fecha_publicacion'];


    $stmt = $pdo->prepare("
    INSERT INTO podcasts
    (titulo,url_embed,fecha_publicacion,usuario_id)
    VALUES (?,?,?,?)
    ");


    $stmt->execute([
        $titulo,
        $url,
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

<title>Nuevo Podcast</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/admin.css">

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
<i class="fas fa-podcast"></i>
Nuevo Podcast
</h4>

</div>


<form method="POST">


<div class="mb-3">

<label>Título</label>

<input 
type="text"
name="titulo"
class="form-control"
required>

</div>



<div class="mb-3">

<label>URL Embed</label>

<input 
type="text"
name="url_embed"
class="form-control"
required>

</div>



<div class="mb-3">

<label>Fecha publicación</label>

<input 
type="date"
name="fecha_publicacion"
class="form-control"
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
