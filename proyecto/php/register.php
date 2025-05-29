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
    $longMaxnom = 20;


if($nom == "" || $pass == "" || $email == "" || $apell == ""){
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($apell) > $longMaxnom){
        $mensaje = "La longitud maxima para el apellido son 20 caracteres";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($nom) > $longMaxnom){
        $mensaje = "La longitud maxima para el nombre son 20 caracteres";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($pass) < $longMin){
        $mensaje = "La contraseña necesita minimo 8 caracteres.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($pass) > $longMax){
        $mensaje = "La longitud maxima de caracteres son 40 caracteres.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(!preg_match('/[A-Z]/', $pass)){
        $mensaje = "La contraseña necesita minimo una mayuscula";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(!preg_match('/[a-z]/', $pass)){
        $mensaje = "La contraseña necesita minimo una minuscula";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(!preg_match('/[0-9]/', $pass)){
        $mensaje = "La contraseña necesita minimo un numero";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strpos($pass, " ") !== false){
        $mensaje = "La contraseña no debe contener espacios en blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}

else{
    $stmt = $enlace->prepare("SELECT correo FROM admin WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_email = $result->fetch_assoc();
    $email_bd = $user_email['correo'];

        if($email_bd == $email){
                $mensaje = "Este correo ya esta registrado";
                echo "<script type='text/javascript'>";
                echo "alert('" . $mensaje . "');"; 
                echo "window.history.back();"; 
                echo "</script>";
                exit; 
        }
        else{
                $insertar = "INSERT INTO admin VALUES(null, '$nom', '$apell', '$email', '$pass_hash', null, null)";
                $ejecutarInsertar = mysqli_query($enlace, $insertar);
                $mensaje = "registro exitoso";
                echo "<script type='text/javascript'>";
                echo "alert('" . $mensaje . "');"; 
                echo "window.location.href = '../login.php'"; 
                echo "</script>";
                exit;
        }

}

    

?>