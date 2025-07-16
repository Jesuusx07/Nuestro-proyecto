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

$usuario = $controlador->eliminar($id_reserva);

header("location: ../reservas.php");

?>