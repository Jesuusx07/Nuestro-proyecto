<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ReservaController.php';

$db = (new Database())->conectar();
$controlador = new ReservaController($db);

if (isset($_GET['id'])) {
    $id_reserva = mysqli_real_escape_string($enlace, $_GET['id']);
}
if (isset($_GET['correo'])) {
    $correo = mysqli_real_escape_string($enlace, $_GET['correo']);
}

$usuario = $controlador->eliminar($id_reserva, $correo);

header("location: ../reservasEmp.php");

?>