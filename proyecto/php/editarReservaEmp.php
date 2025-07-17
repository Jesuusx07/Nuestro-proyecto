<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ReservaController.php';

$db = (new Database())->conectar();
$controlador = new ReservaController($db);

$id_reserva = $_POST["id_reserva"];
$fname = $_POST["nombre"];
$lname = $_POST["apellido"];
$fecha = $_POST["fecha"];
$estado = $_POST["estado"];
$longMin = 8;
$longMax = 50;



if($fname == "" || $lname == "" || $fecha == "" || $estado == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../editarResEmp.php?id=' . $id_reserva . '&nombre=' . $fname . '&apellido=' . $lname . '&fecha=' . $fecha . '&estado=' . $estado); 

    exit();
}

    else{
        if($estado == "Activo"){
            $reserva = $controlador->actualizar($id_reserva, 'Activo', $fecha, $fname, $lname);

            header('Location: ../reservasEmp.php'); 
            exit();
        }    
        else if(strlen($nom) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
else if(strlen($pass) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}    
        elseif($estado == "Inactivo"){
            $reserva = $controlador->actualizar($id_reserva, 'Inactivo', $fecha, $fname, $lname);

            header('Location: ../reservasEmp.php'); 
            exit();
        }
    }


?>