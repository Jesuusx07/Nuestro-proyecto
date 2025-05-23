<?php
require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

// Simulación de autenticación (normalmente usarías base de datos)
    $user = $_POST['correo'];
    $contra = $_POST['contra'];

    $sql = $enlace->query("select * from admin where correo='$user' and contraseña='$contra' ");
    if ($datos = $sql->fetch_object()){
        header("location: ../dashboard.html");
        exit;
    }
    else {
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
?>
