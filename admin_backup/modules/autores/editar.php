<?php
require_once '../../../config/database.php';
session_start();
if (!isset(\['usuario_id'])) { header('Location: ../../login.php'); exit; }

\ = isset(\['id']) ? (int)\['id'] : 0;
if (\ <= 0) { header('Location: index.php'); exit; }

\El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. No se puede cargar el archivo C:\Users\USER\AppData\Local\Programs\Microsoft VS Code\110a328ea5\resources\app\out\vs\workbench\contrib\terminal\common\scripts\shellIntegration.ps1 porque la ejecución de scripts está deshabilitada en este sistema. Para obtener más información, consulta el tema about_Execution_Policies en https:/go.microsoft.com/fwlink/?LinkID=135170. = '';

if (\['REQUEST_METHOD'] == 'POST') {
    // Aquí va la lógica de actualización
    header('Location: index.php?mensaje=editado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <div class="logo-container">
        <img src="../../assets/images/logo.png" alt="Diálogo y Desarrollo">
    </div>
    <div class="user-info">
        <div class="name"><?= htmlspecialchars(\['usuario_nombre'] ?? 'Administrador') ?></div>
        <div class="role"><?= htmlspecialchars(\['usuario_rol'] ?? 'admin') ?></div>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="../../dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a class="nav-link active" href="index.php"><i class="fas fa-folder"></i> <span>Autor</span></a>
        <a class="nav-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> <span>Salir</span></a>
    </nav>
</div>

<div class="main-content">
    <div class="form-container">
        <h4><i class="fas fa-edit"></i> Editar Autor</h4>
        
        <?php if (\El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. No se puede cargar el archivo C:\Users\USER\AppData\Local\Programs\Microsoft VS Code\110a328ea5\resources\app\out\vs\workbench\contrib\terminal\common\scripts\shellIntegration.ps1 porque la ejecución de scripts está deshabilitada en este sistema. Para obtener más información, consulta el tema about_Execution_Policies en https:/go.microsoft.com/fwlink/?LinkID=135170.): ?>
            <div class="alert alert-danger"><?= \El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. El operador -ireplace solo permite que lo sigan dos elementos, no 4. No se puede cargar el archivo C:\Users\USER\AppData\Local\Programs\Microsoft VS Code\110a328ea5\resources\app\out\vs\workbench\contrib\terminal\common\scripts\shellIntegration.ps1 porque la ejecución de scripts está deshabilitada en este sistema. Para obtener más información, consulta el tema about_Execution_Policies en https:/go.microsoft.com/fwlink/?LinkID=135170. ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                    <a href="index.php" class="btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
