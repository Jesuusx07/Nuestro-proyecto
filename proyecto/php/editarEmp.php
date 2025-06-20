<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

$id_empleado = $_POST["id_empleado"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$tele = $_POST["tele"];
$docu = $_POST["documento"];
$select = $_POST["select"];

$password_hash = password_hash($password, PASSWORD_DEFAULT);


if($fname == "" || $lname == "" || $email == "" || $password == "" || $tele == "" || $docu == "" || $select == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../editar_empleado.php?id=1' . $id_empleado); 
    exit();
}
else{
    if(preg_match('/[A-Z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../editar_empleado.php?id=3' . $id_empleado); 
        exit();
    }
    elseif(preg_match('/[a-z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../editar_empleado.php?id=4' . $id_empleado); 
        exit();
    }
    else if(strpos($password, " ") !== false){
        $session->set('error_message', 'La contraseña no puede tener espacios en blanco.');

        header('Location: ../editar_empleado.php?id=5' . $id_empleado); 
        exit();
    }
    else if(strpos($tele, " ") !== false){
        $session->set('error_message', 'El telefono no puede tener espacios en blanco.');

        header('Location: ../editar_empleado.php?id=6' . $id_empleado); 
        exit();
    }
    else{
        if($select == "Mesero"){
            $usuario = $controlador->actualizar($id_empleado, 1, $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }
        elseif($select == "Cocinero"){
            $usuario = $controlador->actualizar($id_empleado, 2, $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }    
        elseif($select == "Limpieza"){
            $usuario = $controlador->actualizar($id_empleado, 3, $fname, $lname, $email, $password_hash, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }

    }


}

?>