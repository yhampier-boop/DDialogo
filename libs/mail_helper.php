<?php
// libs/mail_helper.php

require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($para_email, $para_nombre, $asunto, $cuerpo_html) {
    $config = require __DIR__ . '/../config/mail.php';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['usuario'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = $config['seguridad'];
        $mail->Port       = $config['puerto'];
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom($config['from'], $config['from_nombre']);
        $mail->addAddress($para_email, $para_nombre);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo_html;
        $mail->AltBody = strip_tags($cuerpo_html);
        $mail->send();
        return ['success' => true, 'mensaje' => 'Email enviado correctamente'];
    } catch (Exception $e) {
        return ['success' => false, 'mensaje' => 'Error al enviar: ' . $mail->ErrorInfo];
    }
}