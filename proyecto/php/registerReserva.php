<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ReservaController.php';

$db = (new Database())->conectar();
$controlador = new ReservaController($db);

$date = $_POST["date"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];

$usuarioConectado = $session->getUserName();

$correo = $nombre . $apellido . "@kennys.com";

require_once 'UsuarioController.php';

$db2 = (new Database())->conectar();
$controlador2 = new UsuarioController($db);

$usuario = $controlador2->obtener($correo);
$reserva = $controlador->obtener($date);



if($date == "" || $nombre == "" || $apellido == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../reservasRegis.php'); 
    exit();
}
else{
    if($reserva){
        $session->set('error_message', 'Esta fecha ya esta registrada.');

        header('Location: ../reservasRegis.php');
    }
    elseif($usuario){
        $session->set('error_message', 'Este cliente ya tiene reserva.');

        header('Location: ../reservasRegis.php');
    }
     else{
            $reserva = $controlador->insertar("Activo", $date, "cliente", $nombre, $apellido, $correo, $usuarioConectado);

            header('Location: ../reservas.php'); 
            exit();
        }

}
