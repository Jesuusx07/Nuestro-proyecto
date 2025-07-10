<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ReservaController.php';

$db = (new Database())->conectar();
$controlador = new ReservaController($db);

$date = $_POST["date"];
$nombre = $_POST["nombre"];

$reserva = $controlador->obtener($date);



if($date == "" || $nombre == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../reservasRegis.php'); 
    exit();
}
else{
    if($reserva){
        $session->set('error_message', 'Este reserva ya esta registrado.');

        header('Location: ../reservasRegis.php');
    }
    else{
            $reserva = $controlador->insertar("Activo", $date);

            header('Location: ../reservas.php'); 
            exit();
        }

}
