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

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$usuario = $controlador->obtener($email);



if($fname == "" || $lname == "" || $email == "" || $password == "" || $tele == "" || $docu == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../registerEmpProv.php'); 
    exit();
}
else{
    if(preg_match('/[0-9]/', $lname)){
        $session->set('error_message', 'El apellido no debe contener numeros.');

        header('Location: ../registerEmpProv.php');
        exit(); 
    }   
    else if(preg_match('/[0-9]/', $fname)){
        $session->set('error_message', 'El nombre no debe contener numeros.');

        header('Location: ../registerEmpProv.php');
        exit(); 
    }
    else if($usuario){
        $session->set('error_message', 'Este correo ya esta registrado.');

        header('Location: ../registerEmpProv.php');
    }
    elseif(preg_match('/[A-Z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../registerEmpProv.php'); 
        exit();
    }
    elseif(preg_match('/[a-z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../registerEmpProv.php'); 
        exit();
    }
    elseif(preg_match('/[A-Z]/', $docu)){
        $session->set('error_message', 'No se aceptan letras en el documento.');

        header('Location: ../registerEmpProv.php'); 
        exit();
    }
    elseif(preg_match('/[a-z]/', $docu)){
        $session->set('error_message', 'No se aceptan letras en el documento.');

        header('Location: ../registerEmpProv.php'); 
        exit();
    }
    else if(strpos($password, " ") !== false){
        $session->set('error_message', 'La contraseña no puede tener espacios en blanco.');

        header('Location: ../registerEmpProv.php'); 
        exit();
    }
    else if(strpos($tele, " ") !== false){
        $session->set('error_message', 'El telefono no puede tener espacios en blanco.');

        header('Location: ../registerEmpProv.php'); 
        exit();
    }
    else{

        $usuario = $controlador->insertar("proveedor", $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

        header('Location: ../proveedorEmp.php'); 
        exit();
    }

}



?>