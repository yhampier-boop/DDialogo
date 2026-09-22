<?php

require_once '../../../config/database.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD']=='POST') {


    $nombres = $_POST['nombres'];
    $ap_paterno = $_POST['ap_paterno'];
    $ap_materno = $_POST['ap_materno'];
    $nickname = $_POST['nickname'];
    $es_nickname = isset($_POST['es_nickname']) ? 1 : 0;



    $stmt=$pdo->prepare("
    INSERT INTO autores
    (
    nombres,
    ap_paterno,
    ap_materno,
    nickname,
    es_nickname
    )
    VALUES (?,?,?,?,?)
    ");


    $stmt->execute([
        $nombres,
        $ap_paterno,
        $ap_materno,
        $nickname,
        $es_nickname
    ]);



    header('Location:index.php?mensaje=creado');
    exit;

}

?>


<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Nuevo Autor</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/admin.css">

</head>


<body>


<?php include '../../includes/sidebar.php'; ?>


<div class="main-content">


<div class="table-container">


<div class="table-header">

<h4>

<i class="fas fa-user"></i>

Nuevo Autor

</h4>

</div>



<form method="POST">



<div class="mb-3">

<label>Nombres</label>

<input 
type="text"
name="nombres"
class="form-control"
required>

</div>



<div class="mb-3">

<label>Apellido paterno</label>

<input 
type="text"
name="ap_paterno"
class="form-control">

</div>



<div class="mb-3">

<label>Apellido materno</label>

<input 
type="text"
name="ap_materno"
class="form-control">

</div>



<div class="mb-3">

<label>Nickname</label>

<input 
type="text"
name="nickname"
class="form-control">

</div>



<div class="form-check mb-3">

<input
type="checkbox"
class="form-check-input"
name="es_nickname"
id="nick">


<label class="form-check-label" for="nick">

Usa nickname

</label>

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
