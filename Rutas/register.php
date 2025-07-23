<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once '../config/SessionManager.php'; 
require_once '../config/sql.php'; // Contiene la conexión a la base de datos $enlace

$session = new SessionManager(); 

// 1. Obtener los datos del formulario (usando ?? '' para evitar errores si no se envían)
// Los nombres de las variables ($_POST['nombre'], etc.) deben coincidir con los atributos 'name'
// de los inputs en tu formulario HTML (Vista/registrarse.html).
$nom = $_POST['nombre'] ?? '';
$pass = $_POST['pass'] ?? '';
$email = $_POST['email'] ?? '';
$apell = $_POST['apellido'] ?? '';
$tele = $_POST["telefono"] ?? '';
$docu = $_POST["documento"] ?? '';
$token = null;
$date = null;

// 2. Hashear la contraseña antes de cualquier validación de longitud o caracteres.
//    Esto asegura que siempre trabajas con el hash si decides guardar temporalmente,
//    y la longitud de la contraseña original no es la misma que la del hash.
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// 3. Definir las longitudes mínimas y máximas y otros criterios para la contraseña.
$longMin = 8;
$longMax = 50; // Esta longitud se aplica a la contraseña en texto plano, no al hash.
$longMaxnom = 20; // Longitud máxima para nombres y apellidos.

require_once '../Controlador/UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

$documento = $controlador->obtenerDocu($docu);

// 4. Validaciones de los datos recibidos.
//    Se usan `empty()` para verificar si los campos están vacíos.
if(empty($nom) || empty($pass) || empty($email) || empty($apell) || empty($tele) || empty($docu)){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../Vista/login.php'); 
    exit();
}
// Validación de longitud máxima para apellido.
else if(strlen($apell) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el apellido son 20 caracteres.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}

else if(preg_match('/[0-9]/', $apell)){
    $session->set('error_message', 'El apellido no debe contener numeros.');

    header('Location: ../Vista/registrarse.php');
    exit(); 
}
else if(preg_match('/[0-9]/', $nom)){
    $session->set('error_message', 'El nombre no debe contener numeros.');

    header('Location: ../Vista/registrarse.php');
    exit(); 
}
else if(strlen($nom) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}

elseif(preg_match('/[A-Z]/', $tele)){
    $session->set('error_message', 'No se aceptan letras en el telefono.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
    }
elseif(preg_match('/[a-z]/', $tele)){
    $session->set('error_message', 'No se aceptan letras en el telefono.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
else if(strpos($tele, " ") !== false){
        $session->set('error_message', 'El telefono no puede tener espacios en blanco.');

        header('Location: ../Vista/registrarse.php'); 
        exit();
    }
else if(strlen($pass) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
else if($documento){
    $session->set('error_message', 'Este documento ya esta registrado.');

    header('Location: ../Vista/registrarse.php');
}  
// Validación de longitud máxima para la contraseña.
else if(strlen($pass) > $longMax){
    $session->set('error_message', 'La longitud maxima de la contraseña son 40 caracteres.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
// Validación de mayúscula en la contraseña.
else if(!preg_match('/[A-Z]/', $pass)){
    $session->set('error_message', 'La contraseña necesita al menos una letra mayuscula.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
// Validación de minúscula en la contraseña.
else if(!preg_match('/[a-z]/', $pass)){
    $session->set('error_message', 'La contraseña necesita al menos una letra minuscula.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
// Validación de número en la contraseña.
else if(!preg_match('/[0-9]/', $pass)){
    $session->set('error_message', 'La contraseña necesita al menos un numero.');

    header('Location: ../Vista/registrarse.php');
    exit(); 
}
// Validación de espacios en blanco en la contraseña.
else if(strpos($pass, " ") !== false){
    $session->set('error_message', 'La contraseña no debe contener espacios en blanco.');

    header('Location: ../Vista/registrarse.php');
    exit(); 
}
// Si todas las validaciones pasan...
else {
    // 5. Verificar si el correo ya está registrado en la base de datos.
    // ***MEJORA DE SEGURIDAD Y PREVENCIÓN DE INYECCIÓN SQL:***
    // Se utiliza una sentencia preparada (prepared statement) para evitar inyección SQL.
    // Esto es muy importante cuando insertas datos recibidos del usuario.
    $usuario = $controlador->obtener($email);
    
    // Si se encontró un correo, significa que ya está registrado.
    if($usuario){ // Cambiado de $email_bd == $email a simplemente verificar $user_email
        $session->set('error_message', 'Este correo ya esta registrado.');

        header('Location: ../Vista/registrarse.php');
    exit(); 
    }
    // Si el correo no está registrado, procede con la inserción.
    else {
        // 6. Insertar los datos del nuevo administrador en la base de datos.
        // ***CORRECCIÓN CRÍTICA:*** Nombres de columnas actualizados según tu BDD:
        // 'nombres', 'apellidos', 'correo', 'contraseña'.
        // 'null' para 'id_admin' (AUTO_INCREMENT), 'reset_token', 'reset_token_expires_at'.
        // ***MEJORA DE SEGURIDAD Y PREVENCIÓN DE INYECCIÓN SQL:***
        // Se utiliza otra sentencia preparada para la inserción.
        $usuario = $controlador->insertar('admin', $nom, $apell, $email, $pass_hash, $tele, $docu, $token, $date);

        if ($usuario) {
            $session->set('exito', 'Registro exitoso.');

            header('Location: ../Vista/login.php');

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
                $mail->Subject = 'Registro exitoso';
                // Enlace de recuperación usando el ID del usuario
                // ***CORRECCIÓN:*** Usa $row['id_admin'] para que coincida con tu tabla y el parámetro esperado por change_password.php HTML.
                // ¡ADVERTENCIA DE SEGURIDAD!: Enviar el ID directamente en la URL no es seguro.
                // Asegúrate de que 'http://localhost/Nuestro-proyecto/proyecto/change_password.php' sea la URL correcta de tu proyecto.
                $mail->Body    = 'Hola,<br><br>Registro exitoso. ' .
                                'Por favor, visita la siguiente página para volver a la pagina de login: ' .
                                'http://localhost/Nuestro-proyecto/proyecto/login.php ' . // <--- CAMBIADO: $row['id'] a $row['id_admin']
                                'Si no solicitaste esto, ignora este correo.';
                $mail->send();
                exit(); 
            }catch (Exception $e) {
                // En caso de error en el envío del correo, redirige con un mensaje de error
                // Para depurar: echo "Error al enviar correo: {$mail->ErrorInfo}";
                error_log("Error al enviar correo de recuperación: " . $e->getMessage()); // Guarda el error en los logs del servidor
                header("Location: ../Vista/login.php?message=email_send_error");
                exit(); // Termina el script
            }
        }
        else {
            // Manejo de error si la inserción falla (por ejemplo, problema con la base de datos)
            $session->set('error_message', 'Error con la base de datos.');

            header('Location: ../Vista/registrarse.php');
        }
    }
}
// Cierre de la conexión a la base de datos (Buena práctica).
mysqli_close($enlace);

?>