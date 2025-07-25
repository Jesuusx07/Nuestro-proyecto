<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

$session = new SessionManager();

require_once 'ReservaController.php';

$db = (new Database())->conectar();
$controlador = new ReservaController($db);

$date = $_POST["date"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];

$usuarioConectado = $session->getUserName();

$correo = $nombre . $apellido . "@kennys.com";
$longMin = 8;
$longMax = 50;

if($date == "" || $nombre == "" || $apellido == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../reservasRegis.php'); 
    exit();
}
else if(strlen($nombre) > $longMax){
    $session->set('error_message', 'La longitud maxima para el nombre son 50 caracteres.');

    header('Location: ../reservasRegis.php'); 

    exit();
}


else if(strlen($apellido) > $longMax){

    $session->set('error_message', 'La longitud maxima para el nombre son 50 caracteres.');

    header('Location: ../reservasRegis.php'); 

    exit();
}

require_once 'UsuarioController.php';

$db2 = (new Database())->conectar();
$controlador2 = new UsuarioController($db);

$usuario = $controlador2->obtener($correo);
$reserva = $controlador->obtener($date);

$zonaHorariaBogota = new DateTimeZone('America/Bogota');
$ahora = new DateTime('now', $zonaHorariaBogota);

$format = 'Y-m-d\TH:i';

$nuevaFecha = DateTime::createFromFormat($format, $date, $zonaHorariaBogota); 

    if($reserva){
        $session->set('error_message', 'Esta fecha ya esta registrada.');

        header('Location: ../reservasRegis.php');
    }

    elseif($nuevaFecha < $ahora) {
        $session->set('error_message', 'No se puede reservar una fecha y hora anterior al momento actual.');
        header('Location: ../reservasRegis.php');
        exit();
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


