<?php


require_once '../Config/SessionManager.php';

$session = new SessionManager();

if (!$session->isLoggedIn()) {
} else {
    if ($_SESSION['user_id'] == 1) {
        header("location: ../Vista/dashboard.php");
    } else {
        header("location: ../Vista/dashboardEmp.php");
    }
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
        <p style="text-align: center;">¿No tienes cuenta? <a class="inc" href="registrarse.php">Registrarse</a></p>

        <div>
            <form id="login" action="../Rutas/login.php" method="POST">
                <div class="input-group">
                    <label for="login_email">Correo electrónico</label>
                    <input type="email" id="login_email" name="correo" placeholder="tucorreo@gmail.com">
                </div>

                <div class="input-group">
                    <label for="login_password">Contraseña</label>
                    <input type="password" name="contra" id="login_password">
                </div>
                <button type="submit" class="boton-registro" id="login-submit">Iniciar Sesión</button>

                <a class="inc" href="recovery.php">Olvidaste tu contraseña?</a>

            </form>

            <?php
    // Aquí es donde verificas y muestras el mensaje
            if ($session->has('exito')) {
                echo '<div class="exito">';
                echo '<p>' . htmlspecialchars($session->get('exito')) . '</p>';
                echo '</div>';
                $session->remove('exito'); // Borra el mensaje después de mostrarlo
                $session->remove('error_message'); // Borra el mensaje después de mostrarlo
            }
            else if ($session->has('error_message')) {
                echo '<div class="error-message">';
                echo '<p>' . htmlspecialchars($session->get('error_message')) . '</p>';
                echo '</div>';
                $session->remove('error_message'); // Borra el mensaje después de mostrarlo
            }
            ?>
        </div>

        <style>
            .error-message{
                color: #A02334;
            }

            .exito{
                color: #96CEB4;
            }
        </style>
</body>
</html>