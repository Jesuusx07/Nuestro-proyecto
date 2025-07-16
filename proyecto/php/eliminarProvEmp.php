<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

if (isset($_GET['id'])) {
    $id_empleado = mysqli_real_escape_string($enlace, $_GET['id']);
}

$usuario = $controlador->eliminar($id_empleado);

header("location: ../proveedorEmp.php");

?>