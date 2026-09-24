<?php
$modulo_activo = $modulo_activo ?? '';
?>

<div class="sidebar">

    <div class="logo-container">
        <img src="../../assets/images/iconos/logo.png" alt="Diálogo y Desarrollo">
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
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            <span>Dashboard</span>
        </a>

        <a class="nav-link" href="../reportajes/index.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 3H2v16h20V3zm-2 14H4V5h16v12zM6 7h12v2H6V7zm0 4h12v2H6v-2zm0 4h8v2H6v-2z"/></svg>
            <span>Reportajes</span>
        </a>

        <a class="nav-link" href="../noticias/index.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 11v2h4v-2h-4zm-2 6.61c.96.71 2.21 1.65 3.2 2.39.4-.53.8-1.07 1.2-1.6-.99-.74-2.24-1.68-3.2-2.4-.4.54-.8 1.08-1.2 1.61zM20.4 5.6c-.4-.53-.8-1.07-1.2-1.6-.99.74-2.24 1.68-3.2 2.4.4.53.8 1.07 1.2 1.6.96-.72 2.21-1.65 3.2-2.4zM4 9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h1v4h2v-4h1l5 3V6L8 9H4zm11.5 3c0-1.33-.58-2.53-1.5-3.35v6.69c.92-.81 1.5-2.01 1.5-3.34z"/></svg>
            <span>Noticias</span>
        </a>

        <a class="nav-link" href="../boletines/index.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6 2c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z"/></svg>
            <span>Boletines</span>
        </a>

        <a class="nav-link" href="../podcasts/index.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zm0 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
            <span>Podcasts</span>
        </a>

        <a class="nav-link" href="../videos/index.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
            <span>Videos</span>
        </a>

        <a class="nav-link" href="../autores/index.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            <span>Autores</span>
        </a>

        <a class="nav-link" href="../../logout.php">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            <span>Salir</span>
        </a>

    </nav>

</div>
