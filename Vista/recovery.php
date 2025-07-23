
<?php

require_once '../Config/SessionManager.php';

$session = new SessionManager();

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
        
        <h1>Recuperacion de Contraseña</h1>
        <h3>Por favor, introduzca su correo electronico</h3>

        <div>
            <form id="login" action="../Rutas/recovery.php" method="POST">
                <div class="input-group">
                    <label for="login_email">Correo electrónico</label>
                    <input type="email" id="login_email" name="correo" placeholder="tucorreo@gmail.com">
                </div>

                <button type="submit" class="boton-registro" id="login-submit">Recuperar Contraseña</button> 
            </form>
        </div>
    </div>
</body>
</html>
