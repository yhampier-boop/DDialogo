<?php
// admin/modules/autores/index.php
require_once '../../../config/database.php';
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../../login.php'); exit; }

$mensaje = '';
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'creado') { $mensaje = 'Autor creado exitosamente'; }
    elseif ($_GET['mensaje'] == 'editado') { $mensaje = 'Autor actualizado exitosamente'; }
    elseif ($_GET['mensaje'] == 'eliminado') { $mensaje = 'Autor eliminado exitosamente'; }
}

$items = $pdo->query("SELECT * FROM autores ORDER BY nombres")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
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

<div class="sidebar" style="background: #ffffff !important; background-color: #ffffff !important; box-shadow: 2px 0 15px rgba(0,0,0,0.06) !important; border-right: 1px solid #f0f0f0 !important;">
    <div class="logo-container">
        <img src="/Dialogoydesarrollo/assets/images/iconos/logo.png" alt="Diálogo y Desarrollo">
    </div>
    <div class="user-info">
        <div class="name" style="color: #1a1a2e !important;"><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador') ?></div>
        <div class="role" style="color: #999 !important;"><?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'admin') ?></div>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" style="color: #666 !important;" href="../../dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a class="nav-link active" style="color: #e0020d !important; background: #fff5f5 !important; border-left: 3px solid #e0020d !important;" href="index.php"><i class="fas fa-users"></i> <span>Autores</span></a>
        <a class="nav-link" style="color: #666 !important;" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> <span>Salir</span></a>
    </nav>
</div>

<div class="main-content">
    <div class="table-container">
        <div class="table-header">
            <h4><i class="fas fa-users"></i> Autores</h4>
            <a href="crear.php" class="btn-add"><i class="fas fa-plus"></i> Nuevo Autor</a>
        </div>
        <?php if ($mensaje): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $mensaje ?></div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr><th>#</th><th>Nombres</th><th>Apellido</th><th>Nickname</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php if (count($items) > 0): ?>
                        <?php foreach ($items as $i => $item): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($item['nombres']) ?></td>
                                <td><?= htmlspecialchars($item['ap_paterno'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['nickname'] ?? '-') ?></td>
                                <td>
                                    <a href="editar.php?id=<?= $item['id'] ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i></a>
                                    <a href="eliminar.php?id=<?= $item['id'] ?>" class="btn-action btn-delete" onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">No hay autores</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>





