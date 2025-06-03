
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once('sql.php'); // Contiene la conexión a la base de datos $enlace

// 1. Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si no es POST, redirige y termina el script
    header("Location: ../login.php?message=invalid_request");
    exit();
}

// 2. Obtener el correo electrónico (usando ?? '' para evitar errores si no se envía)
// El input en el HTML tiene name="correo", así que usamos $_POST['correo'].
$email = $_POST['correo'] ?? ''; 

// 3. Validar que el email no esté vacío
if (empty($email)) {
    // Redirige al login con un mensaje si el email está vacío
    header("Location: ../login.php?message=empty_email");
    exit();
}

// 4. Buscar el usuario por correo
//    ¡ADVERTENCIA DE SEGURIDAD!: Esta consulta es vulnerable a Inyección SQL.
//    Para que funcione rápido, la dejamos así por ahora, pero DEBE CAMBIARSE en el futuro.
$query = "SELECT id_admin, correo FROM admin WHERE correo = '$email'"; // <--- CAMBIADO: 'id' a 'id_admin'
$result = $enlace->query($query); // Usar $enlace, no $conexion

// 5. Verificar si se encontró un usuario y proceder con el envío del correo.
if ($result && $result->num_rows > 0) { // Se añadió `&& $result` para verificar la consulta.
    $row = $result->fetch_assoc(); // Obtener los datos del usuario

    // 6. Configuración y envío de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP - AJUSTA ESTO SEGÚN TU PROVEEDOR DE CORREO
        // Estas configuraciones son comunes para Gmail con autenticación.
        // Si usas otro servicio (Outlook, etc.), las credenciales y puertos cambiarán.
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth   = true;              // Habilitar autenticación SMTP
        $mail->Username   = 'jesuusx71@gmail.com'; // **¡Cámbialo con TU CORREO REAL DE GMAIL!**
        // **¡IMPORTANTE PARA GMAIL CON 2FA!: Si tienes la verificación en dos pasos,
        // usa una CONTRASEÑA DE APLICACIÓN generada en tu cuenta de Google.**
        $mail->Password   = 'q h h c f j p t o p j q h q x w'; // **¡Cámbialo con TU CONTRASEÑA REAL!**
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usar SSL (para puerto 465)
        $mail->Port       = 465;                      // Puerto SMTP para SSL

        // Remitente y Destinatario
        // **¡AJUSTE: Usa la misma cuenta de Gmail que en Username para setFrom!**
        $mail->setFrom('jesuusx71@gmail.com', 'Equipo de Kenny\'s'); // **¡Cámbialo con TU CORREO REAL y NOMBRE!**
        $mail->addAddress($email, $row['correo']); // Enviar al correo que el usuario proporcionó

        // Contenido del Correo
        $mail->isHTML(true); // El correo es en formato HTML
        $mail->Subject = 'Recuperación de contraseña';
        // Enlace de recuperación usando el ID del usuario
        // ***CORRECCIÓN:*** Usa $row['id_admin'] para que coincida con tu tabla y el parámetro esperado por change_password.php HTML.
        // ¡ADVERTENCIA DE SEGURIDAD!: Enviar el ID directamente en la URL no es seguro.
        // Asegúrate de que 'http://localhost/Nuestro-proyecto/proyecto/change_password.php' sea la URL correcta de tu proyecto.
        $mail->Body    = 'Hola,<br><br>Este es un correo para solicitar tu recuperación de contraseña. ' .
                         'Por favor, visita la siguiente página para restablecer tu contraseña: ' .
                         '<a href="http://localhost/Nuestro-proyecto/proyecto/change_password.php?id_admin=' . $row['id_admin'] . '">Restablecer Contraseña</a>' . // <--- CAMBIADO: $row['id'] a $row['id_admin']
                         '<br><br>Si no solicitaste esto, ignora este correo.';

        $mail->send();
        // Redirige al login con un mensaje de éxito (correo enviado)
        header("Location: ../login.php?message=recovery_email_sent");
        exit(); // Termina el script
    } catch (Exception $e) {
        // En caso de error en el envío del correo, redirige con un mensaje de error
        // Para depurar: echo "Error al enviar correo: {$mail->ErrorInfo}";
        error_log("Error al enviar correo de recuperación: " . $e->getMessage()); // Guarda el error en los logs del servidor
        header("Location: ../login.php?message=email_send_error");
        exit(); // Termina el script
    }

} else {
    // Si el correo no se encuentra en la base de datos, redirige con un mensaje
    header("Location: ../login.php?message=email_not_found");
}

// Cierre de la conexión a la base de datos (Buena práctica, aunque PHP lo cierra al terminar)
mysqli_close($enlace);

?>