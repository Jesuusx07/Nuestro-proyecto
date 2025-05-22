<?php
require_once 'SessionManager.php';

$session = new SessionManager();

// Simulación de autenticación (normalmente usarías base de datos)
    $user = $_POST['correo'];
    $pass = $_POST['pass'];

    if ($user === 'admin@gmail.com' && $pass === '1234') {
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
