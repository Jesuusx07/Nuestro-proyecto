<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["correo"])) {
    $correoDestino = $_POST["correo"];
    $token = bin2hex(random_bytes(16)); // Token de seguridad para el enlace

    // Aquí puedes guardar el token en tu base de datos junto con el email y una fecha de expiración

    $enlace = "http://localhost/Nuestro-proyecto/Nuestro-proyecto/proyecto/forgotPASS.php" . $token;

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jesuusx71@gmail.com'; // <-- Tu correo Gmail
        $mail->Password   = 'j d u n v y k s f r v k f z y f'; // <-- Contraseña de aplicación de Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Configurar remitente y destinatario
        $mail->setFrom('jesuusx71@gmail.com', 'Tu Nombre o Sistema');
        $mail->addAddress($correoDestino);

        // Contenido del mensaje
        $mail->isHTML(true);
        $mail->Subject = 'Restablece tu contraseña';
        $mail->Body    = "
            <h2>Solicitud para restablecer contraseña</h2>
            <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
            <p><a href='$enlace'>$enlace</a></p>
            <p>Este enlace expirará en 1 hora.</p>
        ";

        $mail->send();
        echo "Correo enviado correctamente. Revisa tu bandeja.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "Petición inválida.";
}
