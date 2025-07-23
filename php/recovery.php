<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recuperar Contraseña</title>
  <style>
    .toast {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4CAF50;
      color: white;
      padding: 15px 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      font-family: Arial, sans-serif;
      font-size: 16px;
      z-index: 1000;
      animation: fadein 0.5s, fadeout 0.5s 1.5s;
    }

    @keyframes fadein {
      from { opacity: 0; top: 0; }
      to { opacity: 1; top: 20px; }
    }

    @keyframes fadeout {
      from { opacity: 1; top: 20px; }
      to { opacity: 0; top: 0; }
    }
  </style>
</head>
<body>
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
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('jesuusx71@gmail.com', 'Equipo de Kenny\'s');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de Contraseña';
        $mail->Body    = 'Hola,<br><br>Este es un correo para solicitar tu recuperación de contraseña. ' .
                         'Por favor, visita la siguiente página para restablecer tu contraseña: ' .
                         '<a href="http://localhost/Nuestro-proyecto/proyecto/change_password.php?id_usuario=' . $row['id_usuario'] . '">Restablecer Contraseña</a>' .
                         '<br><br>Si no solicitaste esto, ignora este correo.';

        $mail->send();

        // Mostrar toast y redirigir con JS
        echo "<div class='toast'>Correo enviado correctamente.</div>";
        echo "<script>
            setTimeout(() => {
                window.location.href = '../login.php';
            }, 2000);
        </script>";
        exit();
    } catch (Exception $e) {
        error_log('Error al enviar correo: ' . $e->getMessage());
        header("Location: ../login.php?message=email_send_error");
        exit();
    }

} else {
    header("Location: ../login.php?message=email_not_found");
}

// Cierre de la conexión
mysqli_close($enlace);
?>
</body>
</html>
