<?php
// forgot_password.php
session_start();
require 'sql.php'; // Incluye tu archivo de conexión a la base de datos con mysqli

// Incluir las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php'; // Asegúrate que la ruta sea correcta
require 'phpmailer/src/PHPMailer.php'; // Asegúrate que la ruta sea correcta
require 'phpmailer/src/SMTP.php';     // Asegúrate que la ruta sea correcta y si usas SMTP

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $message = 'Por favor, introduce tu correo electrónico.';
    } else {
        $user = null;
        $user_table = '';
        $user_id_column = '';

        // --- Buscar en la tabla 'admin' ---
        $stmt_admin = mysqli_prepare($enlace, 'SELECT id_admin, correo FROM admin WHERE correo = ?');
        mysqli_stmt_bind_param($stmt_admin, 's', $email);
        mysqli_stmt_execute($stmt_admin);
        $result_admin = mysqli_stmt_get_result($stmt_admin);
        if (mysqli_num_rows($result_admin) > 0) {
            $user = mysqli_fetch_assoc($result_admin);
            $user_table = 'admin';
            $user_id_column = 'id_admin';
        }
        mysqli_stmt_close($stmt_admin);

        // --- Si no se encuentra en 'admin', buscar en la tabla 'empleado' ---
        if (!$user) {
            $stmt_empleado = mysqli_prepare($enlace, 'SELECT id_empleado, correo FROM empleado WHERE correo = ?');
            mysqli_stmt_bind_param($stmt_empleado, 's', $email);
            mysqli_stmt_execute($stmt_empleado);
            $result_empleado = mysqli_stmt_get_result($stmt_empleado);
            if (mysqli_num_rows($result_empleado) > 0) {
                $user = mysqli_fetch_assoc($result_empleado);
                $user_table = 'empleado';
                $user_id_column = 'id_empleado';
            }
            mysqli_stmt_close($stmt_empleado);
        }

        if ($user) {
            $token = bin2hex(random_bytes(32)); // Genera un token seguro
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token válido por 1 hora

            // Actualizar el token y la fecha de expiración en la tabla correspondiente
            $update_query = "UPDATE {$user_table} SET reset_token = ?, reset_token_expires_at = ? WHERE {$user_id_column} = ?";
            $stmt_update = mysqli_prepare($enlace, $update_query);
            mysqli_stmt_bind_param($stmt_update, 'ssi', $token, $expires, $user[$user_id_column]); // 'ssi' para string, string, integer
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            // Construir el enlace de restablecimiento
            // ¡IMPORTANTE! Reemplaza 'http://yourdomain.com' con la URL base de tu aplicación
            $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;

            // --- Lógica para enviar el correo electrónico con PHPMailer ---
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Por ejemplo, para Gmail. Consulta a tu proveedor.
                $mail->SMTPAuth   = true;
                $mail->Username   = 'tu_correo@gmail.com'; // <-- ¡IMPORTANTE! Tu dirección de correo de envío
                $mail->Password   = 'tu_contraseña_o_app_password'; // <-- ¡IMPORTANTE! Tu contraseña o contraseña de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usa SMTPS (SSL)
                $mail->Port       = 465; // Puerto estándar para SMTPS

                // Remitente y destinatario
                $mail->setFrom('tu_correo@gmail.com', 'Kenny\'s Aplicación');
                $mail->addAddress($email);

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Restablecimiento de Contraseña para Kenny\'s Aplicación';
                $mail->Body    = 'Hola,<br><br>'
                               . 'Has solicitado restablecer tu contraseña. Para continuar, haz clic en el siguiente enlace:<br><br>'
                               . '<a href="' . htmlspecialchars($reset_link) . '">' . htmlspecialchars($reset_link) . '</a><br><br>'
                               . 'Este enlace expirará en 1 hora.<br><br>'
                               . 'Si no solicitaste un restablecimiento de contraseña, por favor, ignora este correo.<br><br>'
                               . 'Saludos cordiales,<br>El Equipo de Kenny\'s Aplicación';
                $mail->AltBody = 'Hola, Has solicitado restablecer tu contraseña. Para continuar, copia y pega el siguiente enlace en tu navegador: '
                               . htmlspecialchars($reset_link) . ' Este enlace expirará en 1 hora. Si no solicitaste un restablecimiento de contraseña, ignora este correo. Saludos cordiales, El Equipo de Kenny\'s Aplicación';

                $mail->send();
                $message = 'Se ha enviado un enlace de restablecimiento a tu correo electrónico. Por favor, revisa tu bandeja de entrada.';
            } catch (Exception $e) {
                $message = 'Lo sentimos, no pudimos enviar el correo de restablecimiento en este momento. Por favor, inténtalo de nuevo más tarde.';
                // Para depuración: error_log("Error al enviar correo: {$mail->ErrorInfo}");
            }
        } else {
            // Mensaje de seguridad para evitar la enumeración de correos
            $message = 'Si tu correo electrónico está asociado a una cuenta, recibirás un enlace para restablecer tu contraseña.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 400px; width: 100%; text-align: center; }
        h2 { color: #333; margin-bottom: 20px; }
        input[type="email"], input[type="submit"] { width: calc(100% - 20px); padding: 12px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ddd; font-size: 16px; }
        input[type="submit"] { background-color: #007bff; color: white; cursor: pointer; border: none; font-weight: bold; transition: background-color 0.3s ease; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .message { color: green; margin-bottom: 15px; font-weight: bold; }
        .error { color: red; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperar Contraseña</h2>
        <?php if (!empty($message)): ?>
            <p class="<?php echo (strpos($message, 'revisa tu bandeja de entrada') !== false || strpos($message, 'recibirás un enlace') !== false) ? 'message' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>
        <form action="forgot_password.php" method="POST">
            <label for="email" style="display: block; text-align: left; margin-bottom: 8px; color: #555;">Introduce tu correo electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="tu@ejemplo.com">
            <input type="submit" value="Enviar Enlace de Recuperación">
        </form>
    </div>
</body>
</html>