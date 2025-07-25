<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

$session = new SessionManager();

require_once '../Controlador/ProductoController.php';

$db = (new Database())->conectar();
$controlador = new ProductoController($db);

if (isset($_GET['id'])) {
    $id_producto = mysqli_real_escape_string($enlace, $_GET['id']);
}

$producto = $controlador->eliminar($id_producto);

header("location: ../Modelo/producto.php");

?>