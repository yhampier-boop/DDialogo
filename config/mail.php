<?php
// config/mail.php
$local = __DIR__ . '/mail.local.php';
$credenciales = file_exists($local) ? require $local : ['password' => ''];

return [
    'host'        => 'smtp.gmail.com',
    'puerto'      => 587,
    'seguridad'   => 'tls',
    'usuario'     => '022200780e@uandina.edu.pe',
    'password'    => $credenciales['password'],
    'from'        => '022200780e@uandina.edu.pe',
    'from_nombre' => 'Dialogo y Desarrollo',
    'url_base'    => 'http://localhost/Dialogoydesarrollo',
];
