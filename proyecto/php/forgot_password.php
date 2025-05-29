<?php
// Importar clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargar el autoload de Composer
require 'vendor/autoload.php';

// Crear instancia de PHPMailer
$mail = new PHPMailer(true);
// HABILITAR DEBUG
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Cambia esto por el servidor SMTP que vayas a usar
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bhrqzln@gmail.com'; // Tu correo
    $mail->Password   = 'xzkwcuxchdeczbjx'; // Tu contraseña (o contraseña de aplicación)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // O STARTTLS
    $mail->Port       = 465; // O 587 para STARTTLS

    // Remitente y destinatario
    $mail->setFrom('bhrqzln@gmail.com', 'LinaTlr');
    $mail->addAddress('dayanalizeth067@gmail.com', 'DayanaPt');

    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Este es el cuerpo del correo <b>en HTML</b>';
    $mail->AltBody = 'Este es el cuerpo del correo en texto plano';

    // Enviar el correo
    $mail->send();
    echo 'El mensaje fue enviado correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
}