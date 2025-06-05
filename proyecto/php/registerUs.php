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
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../registerUs.php'); 
    exit();
}
else{
    if($email_bd == $email){
        $session->set('error_message', 'Este correo ya esta registrado.');

        header('Location: ../registerUs.php'); 
        exit();
    }
    elseif(preg_match('/[A-Z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../registerUs.php'); 
        exit();
    }
        elseif(preg_match('/[a-z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../registerUs.php'); 
        exit();
    }
    else if(strpos($password, " ") !== false){
        $session->set('error_message', 'La contraseña no puede tener espacios en blanco.');

        header('Location: ../registerUs.php'); 
        exit();
    }
    else if(strpos($tele, " ") !== false){
        $session->set('error_message', 'El telefono no puede tener espacios en blanco.');

        header('Location: ../registerUs.php'); 
        exit();
    }
    elseif($select == "Mesero"){
        $insertar = "INSERT INTO empleado VALUES(null, 1, '$fname', '$lname', '$email', '$password_hash', '$tele', '$docu', null, null)";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $session->set('exito', 'Empleado registrado exitosamente.');

        header('Location: ../registerUs.php'); 
        exit();
    }
    elseif($select == "Cocinero"){
        $insertar = "INSERT INTO empleado VALUES(null, 2, '$fname', '$lname', '$email', '$password_hash', '$tele', '$docu', null, null)";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $session->set('exito', 'Empleado registrado exitosamente.');

        header('Location: ../registerUs.php'); 
        exit();
    }    
    elseif($select == "Limpieza"){
        $insertar = "INSERT INTO empleado VALUES(null, 3, '$fname', '$lname', '$email', '$password_hash', '$tele', '$docu', null, null)";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $session->set('exito', 'Empleado registrado exitosamente.');

        header('Location: ../registerUs.php'); 
        exit();
    }


}

?>