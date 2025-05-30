<?php

require_once './php/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
    }else{
        if($_SESSION['user_id'] == 1){
            header("location: dashboard.php");
        }
        else{
            header("location: dashboardEmp.php");
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

                <a href="forgotPASS.php" class="Recupera">¿Olvidaste tu contraseña?</a>
                
            </form>
        </div>
    </div>
</body>
</html>
