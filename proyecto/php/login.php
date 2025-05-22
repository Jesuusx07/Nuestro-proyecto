<?php
require_once 'SessionManager.php';
require_once 'register.php';

$session = new SessionManager();

// Simulación de autenticación (normalmente usarías base de datos)
    $user = $_GET['correo'];
    $passw = $_GET['passw'];

    if ($user == $email && $passw == $pass) {
        $session->login(1, $user);
        header('Location: ../dashboard.html');
        exit;

    } else {
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
?>
