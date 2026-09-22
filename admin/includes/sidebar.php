<?php
$modulo_activo = $modulo_activo ?? '';
?>

<div class="sidebar">

    <div class="logo-container">
        <img src="/Dialogoydesarrollo/admin/assets/images/logo.png" alt="Diálogo y Desarrollo">
    </div>

    <div class="user-info">
        <div class="name">
            <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador') ?>
        </div>

        <div class="role">
            <?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'admin') ?>
        </div>
    </div>

    <nav class="nav flex-column">

        <a class="nav-link" href="../../dashboard.php">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>

        <a class="nav-link" href="../reportajes/index.php">
            <i class="fas fa-newspaper"></i>
            <span>Reportajes</span>
        </a>

        <a class="nav-link" href="../noticias/index.php">
            <i class="fas fa-bullhorn"></i>
            <span>Noticias</span>
        </a>

        <a class="nav-link" href="../boletines/index.php">
            <i class="fas fa-file"></i>
            <span>Boletines</span>
        </a>

        <a class="nav-link" href="../podcasts/index.php">
            <i class="fas fa-podcast"></i>
            <span>Podcasts</span>
        </a>

        <a class="nav-link" href="../videos/index.php">
            <i class="fas fa-video"></i>
            <span>Videos</span>
        </a>

        <a class="nav-link" href="../autores/index.php">
            <i class="fas fa-users"></i>
            <span>Autores</span>
        </a>

        <a class="nav-link" href="../../logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Salir</span>
        </a>

    </nav>

</div>
