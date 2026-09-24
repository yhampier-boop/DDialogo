<?php
// config/session.php
// Iniciar sesion de forma segura

if (session_status() === PHP_SESSION_NONE) {
    // Detectar HTTPS
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
          || ($_SERVER['SERVER_PORT'] ?? 80) == 443;
    
    // Configurar cookies de sesion seguras
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $https,       // Solo HTTPS (en produccion)
        'httponly' => true,          // No accesible desde JS
        'samesite' => 'Strict',      // Anti-CSRF
    ]);
    
    // Regenerar ID para prevenir session fixation
    session_start();
    
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } elseif (time() - $_SESSION['created'] > 1800) {
        // Regenerar cada 30 minutos
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}