<?php
// login.php

require_once './php/SessionManager.php';

$session = new SessionManager();

if (!$session->isLoggedIn()){
    // Si el usuario NO ha iniciado sesión, no hacemos nada (continúa mostrando el login).
}else{
    // Si el usuario YA ha iniciado sesión, lo redirigimos al dashboard.
    header("location: dashboard.php");
    exit(); // Es importante usar exit() después de un header() para asegurar la redirección.
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenny's - Aplicación Web</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="container">
        <a href="index.html"> <img class="logo" src="img/Logo Principal (1).png" alt="Kenny's Logo"> </a>

        <h1>Inicia sesión</h1>
        <p style="text-align: center;">¿No tienes cuenta? <a class="inc" href="registrarse.html">Registrarse</a></p>

        <div>
            <form id="login" action="./php/login.php" method="POST">
                <div class="input-group">
                    <label for="login_email">Correo electrónico</label>
                    <input type="email" id="login_email" name="correo" placeholder="tucorreo@gmail.com">
                </div>

                <div class="input-group">
                    <label for="login_password">Contraseña</label>
                    <input type="password" name="contra" id="login_password">
                </div>
                <button type="submit" class="boton-registro" id="login-submit">Iniciar Sesión</button>

                <a href="recovery.php" class="Recupera">¿Olvidaste tu contraseña?</a>

            </form>
        </div>

        <?php
        // Este bloque PHP muestra los mensajes pasados por URL (GET).
        if(isset($_GET['message'])){
        ?>
            <div class="alert alert-primary" role="alert">
               <?php
               switch ($_GET['message']) {
                   case 'ok':
                       echo 'Por favor, revisa tu correo'; // Este mensaje ya lo tenías.
                       break;
                   // --- MENSAJES DEL PROCESO DE LOGIN ---
                   case 'empty_credentials':
                       echo 'Por favor, introduce tu correo electrónico y tu contraseña.';
                       break;
                   case 'invalid_credentials':
                       echo 'Credenciales inválidas. Por favor, verifica tu correo y contraseña.';
                       break;
                   // --- MENSAJES DE RECUPERACIÓN DE CONTRASEÑA ---
                   case 'recovery_email_sent':
                       echo 'Se ha enviado un correo electrónico a tu dirección. Por favor, sigue las instrucciones para restablecer tu contraseña.';
                       break;
                   case 'email_send_error':
                       echo 'Hubo un error al enviar el correo electrónico. Por favor, inténtalo de nuevo más tarde.';
                       break;
                   case 'email_not_found':
                       echo 'No se encontró ninguna cuenta con ese correo electrónico.';
                       break;
                   case 'password_changed_ok':
                       echo '¡Contraseña restablecida exitosamente! Ya puedes iniciar sesión con tu nueva contraseña.';
                       break;
                   case 'password_changed_error':
                       echo 'Hubo un error al restablecer tu contraseña. Inténtalo de nuevo o contacta al soporte.';
                       break;
                   // --- MENSAJES DE REGISTRO (EJEMPLOS) ---
                   case 'registration_success':
                       echo '¡Registro exitoso! Ya puedes iniciar sesión con tu nueva cuenta.';
                       break;
                   case 'registration_error':
                       echo 'Hubo un error al registrar tu cuenta. Intenta de nuevo.';
                       break;
                   case 'email_already_registered':
                       echo 'El correo electrónico ya está registrado. Por favor, usa otro o inicia sesión.';
                       break;
                   // --- OTROS MENSAJES GENERALES ---
                   case 'invalid_request':
                       echo 'Solicitud inválida. Por favor, intenta desde el formulario.';
                       break;
                   default:
                       // Mensaje por defecto si el 'message' no coincide con ningún caso conocido.
                       echo 'Algo salió mal, intenta de nuevo o: ' . htmlspecialchars($_GET['message']);
                       break;
               }
               ?>
            </div>
        <?php
        } // Cierre del if(isset($_GET['message']))
        ?>
</body>
</html>