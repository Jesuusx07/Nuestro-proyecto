<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

$id_usuario = $_POST["id_usuario"];
$id_rol = $_POST["id_rol"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$tele = $_POST["tele"];
$docu = $_POST["documento"];
$select = $_POST["select"];

$longMin = 8;
$longMax = 50;


if($fname == "" || $lname == "" || $email == "" || $tele == "" || $docu == "" || $select == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../editar_empleado.php?id=' . $id_usuario . '&id_rol=' . $id_rol . '&nom=' . $fname . '&apell=' . $lname . '&email=' . $email . '&tel=' . $tele . '&docu=' . $docu); 

    exit();
}
else{
    if(preg_match('/[A-Z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../editar_empleado.php?id=' . $id_usuario . '&id_rol=' . $id_rol . '&nom=' . $fname . '&apell=' . $lname . '&email=' . $email . '&tel=' . $tele . '&docu=' . $docu); 

        exit();
    }
    elseif(preg_match('/[a-z]/', $tele)){
        $session->set('error_message', 'No se aceptan letras en el telefono.');

        header('Location: ../editar_empleado.php?id=' . $id_usuario . '&id_rol=' . $id_rol . '&nom=' . $fname . '&apell=' . $lname . '&email=' . $email . '&tel=' . $tele . '&docu=' . $docu);

        exit();
    }
 
else if(strlen($nom) > $longMax){

    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

        header('Location: ../editar_empleado.php?id=' . $id_usuario . '&id_rol=' . $id_rol . '&nom=' . $fname . '&apell=' . $lname . '&email=' . $email . '&tel=' . $tele . '&docu=' . $docu);
}

    else if(strpos($tele, " ") !== false){
        $session->set('error_message', 'El telefono no puede tener espacios en blanco.');

        header('Location: ../editar_empleado.php?id=' . $id_usuario . '&id_rol=' . $id_rol . '&nom=' . $fname . '&apell=' . $lname . '&email=' . $email . '&tel=' . $tele . '&docu=' . $docu);

        exit();
    }
    else{
        if($select == "Mesero"){
            $usuario = $controlador->actualizar($id_usuario, 'Mesero', $fname, $lname, $email, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }
        elseif($select == "Cocinero"){
            $usuario = $controlador->actualizar($id_usuario, 'Cocinero', $fname, $lname, $email, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }    
        elseif($select == "Limpieza"){
            $usuario = $controlador->actualizar($id_usuario, 'Limpieza', $fname, $lname, $email, $tele, $docu, null, null);

            header('Location: ../empleado.php'); 
            exit();
        }

    }


}

?>