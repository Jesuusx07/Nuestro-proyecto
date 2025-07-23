<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ReservaController.php';

$db = (new Database())->conectar();
$controlador = new ReservaController($db);

$id_reserva = $_POST["id"];
$fecha = $_POST["fecha"];
$estado = $_POST["estado"];
$longMin = 8;
$longMax = 50;
if($fecha == "" || $estado == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../editar_reserva.php?id=' . $id_reserva . '&fecha=' . $fecha . '&estado=' . $estado); 

    exit();
}

$zonaHorariaBogota = new DateTimeZone('America/Bogota');
$ahora = new DateTime('now', $zonaHorariaBogota);

$format = 'Y-m-d\TH:i';

$nuevaFecha = DateTime::createFromFormat($format, $fecha, $zonaHorariaBogota); 

if($nuevaFecha < $ahora) {
    $session->set('error_message', 'No se puede reservar una fecha y hora anterior al momento actual.');
    header('Location: ../editar_reserva.php?id=' . $id_reserva . '&fecha=' . $fecha . '&estado=' . $estado);
    exit();
}
    else{
        if($estado == "Activo"){

            $reserva = $controlador->actualizar($id_reserva, "Activo", $fecha);

            header('Location: ../reservas.php'); 
            exit();
        }       

        elseif($estado == "Inactivo"){
            $reserva = $controlador->actualizar($id_reserva, "Inactivo", $fecha);

            header('Location: ../reservas.php'); 
            exit();
        }
}


?>