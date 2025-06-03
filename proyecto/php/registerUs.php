<?php

require_once 'sql.php';

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$tele = $_POST["tele"];
$docu = $_POST["documento"];
$select = $_POST["select"];

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $enlace->prepare("SELECT correo FROM empleado WHERE correo = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user_email = $result->fetch_assoc();
$email_bd = $user_email['correo'];


if($fname == "" || $lname == "" || $email == "" || $password == "" || $tele == "" || $docu == "" || $select == ""){
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else{
    if($email_bd == $email){
        $mensaje = "Este correo ya esta registrado";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
    elseif(preg_match('/[A-Z]/', $tele)){
        $mensaje = "No se aceptan letras en el telefono";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
        elseif(preg_match('/[a-z]/', $tele)){
        $mensaje = "No se aceptan letras en el telefono";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
    else if(strpos($password, " ") !== false){
        $mensaje = "La contraseña no puede contener espacios es blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
    else if(strpos($tele, " ") !== false){
        $mensaje = "El telefono no puede contener espacios es blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
    elseif($select == "Mesero"){
        $insertar = "INSERT INTO empleado VALUES(null, 1, '$fname', '$lname', '$email', '$password_hash', '$tele', '$docu', null, null)";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $mensaje = "Registro exitoso.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
    }
    elseif($select == "Cocinero"){
        $insertar = "INSERT INTO empleado VALUES(null, 2, '$fname', '$lname', '$email', '$password_hash', '$tele', '$docu', null, null)";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $mensaje = "Registro exitoso.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
    }    
    elseif($select == "Limpieza"){
        $insertar = "INSERT INTO empleado VALUES(null, 3, '$fname', '$lname', '$email', '$password_hash', '$tele', '$docu', null, null)";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $mensaje = "Registro exitoso.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
    }


}

?>