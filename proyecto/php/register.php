<?php
require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

    $nom = $_POST['nombre'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $apell = $_POST['apellido'];

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $longMin = 8;
    $longMax = 40;

if($nom == "" || $pass == "" || $email == "" || $apell == ""){
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else if(strlen($pass) < $longMin){
        $mensaje = "La contraseña necesita minimo 8 caracteres.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else if(strlen($pass) > $longMax){
        $mensaje = "La longitud maxima de caracteres son 40 caracteres.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else if(!preg_match('/[A-Z]/', $pass)){
        $mensaje = "La contraseña necesita minimo una mayuscula";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else if(!preg_match('/[a-z]/', $pass)){
        $mensaje = "La contraseña necesita minimo una minuscula";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else if(!preg_match('/[0-9]/', $pass)){
        $mensaje = "La contraseña necesita minimo un numero";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}else if(strpos($pass, " ") !== false){
        $mensaje = "La contraseña no debe contener espacios en blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}

else{
        $insertar = "INSERT INTO admin VALUES('', '$nom', '$apell', '$email', '$pass_hash')";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $mensaje = "registro exitoso";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.location.href = '../login.html'"; 
        echo "</script>";

}

    

?>