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
    header("Location: ../login.php?message=invalid_request");
    exit();
}

// 2. Obtener el correo electrónico
$email = $_POST['correo'] ?? ''; 

// 3. Validar que el email no esté vacío
if (empty($email)) {
    header("Location: ../login.php?message=empty_email");
    exit();
}

// 4. Buscar el usuario por correo
$query = "SELECT id_usuario, correo FROM usuario WHERE correo = '$email'";
$result = $enlace->query($query);

// 5. Verificar si se encontró un usuario
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jesuusx71@gmail.com';
        $mail->Password   = 'q h h c f j p t o p j q h q x w'; // Usa una contraseña de aplicación si es necesario
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('jesuusx71@gmail.com', 'Equipo de Kenny\'s');
        $mail->addAddress($email);

        // Enlace con id_usuario en vez de id_admin
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body    = 'Hola,<br><br>Este es un correo para solicitar tu recuperación de contraseña. ' .
                         'Por favor, visita la siguiente página para restablecer tu contraseña: ' .
                         '<a href="http://localhost/Nuestro-proyecto/proyecto/change_password.php?id_usuario=' . $row['id_usuario'] . '">Restablecer Contraseña</a>' .
                         '<br><br>Si no solicitaste esto, ignora este correo.';

        $mail->send();

        echo "<script type='text/javascript'>";
        echo "alert('Correo enviado.');"; 
        echo "window.location.href = '../login.php'";
        echo "</script>";
        exit();
    } catch (Exception $e) {
        error_log("Error al enviar correo de recuperación: " . $e->getMessage());
        header("Location: ../login.php?message=email_send_error");
        exit();
    }

} else {
    header("Location: ../login.php?message=email_not_found");
}

// Cierre de la conexión
mysqli_close($enlace);
?>
