<?php
require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

    $nom = $_POST['nombre'];
    $pass = $_POST['pass'];
    $email = $_POST['correo'];
    $apell = $_POST['apellido'];

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

if($nom == "" || $pass == "" || $email == "" || $apell == ""){
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else{
        $insertar = "INSERT INTO admin VALUES('', '$nom', '$apell', '$email', '$pass_hash')";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        header('Location: ../login.html');
        $mensaje = "Registro exitoso.";
        echo "$mensaje";
}

    

?>