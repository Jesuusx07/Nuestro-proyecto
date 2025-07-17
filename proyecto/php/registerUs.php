<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$tele = $_POST["tele"];
$docu = $_POST["documento"];
$select = $_POST["select"];


$password_hash = password_hash($password, PASSWORD_DEFAULT);

$documento = $controlador->obtenerDocu($docu);
$usuario = $controlador->obtener($email);

$longMin = 8;
$longMax = 50;

if($fname == "" || $lname == "" || $email == "" || $password == "" || $tele == "" || $docu == "" || $select == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../registerUs.php'); 
    exit();
}
else{
    if(preg_match('/[0-9]/', $lname)){
        $session->set('error_message', 'El apellido no debe contener numeros.');

        header('Location: ../registerUs.php');
        exit(); 
    } 
    else if(preg_match('/[0-9]/', $fname)){
        $session->set('error_message', 'El nombre no debe contener numeros.');

        header('Location: ../registerUs.php');
        exit(); 
    }
    
    else if($usuario){
        $session->set('error_message', 'Este correo ya esta registrado.');

        header('Location: ../registerUs.php');
    }
    
else if(strlen($fname) > $longMax){
    $session->set('error_message', 'La longitud maxima para el nombre son 50 caracteres.');

    header('Location: ../registerUs.php'); 
    exit();
}
else if(strlen($password) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../registerUs.php'); 
    exit();
}
    else if($documento){
        $session->set('error_message', 'Este documento ya esta registrado.');

        header('Location: ../registerUs.php');
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
    elseif(preg_match('/[A-Z]/', $docu)){
        $session->set('error_message', 'No se aceptan letras en el documento.');

        header('Location: ../registerUs.php'); 
        exit();
    }
    elseif(preg_match('/[a-z]/', $docu)){
        $session->set('error_message', 'No se aceptan letras en el documento.');

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
    else{
        if($select == "Mesero"){
            $usuario = $controlador->insertar("Mesero", $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }
        elseif($select == "Cocinero"){
            $usuario = $controlador->insertar("Cocinero", $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }    
        elseif($select == "Limpieza"){
            $usuario = $controlador->insertar("Limpieza", $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }

    }


}

?>