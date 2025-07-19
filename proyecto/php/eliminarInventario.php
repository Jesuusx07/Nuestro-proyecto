<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'InventarioController.php';

$db = (new Database())->conectar();
$controlador = new InventarioController($db);

if (isset($_GET['id_inventario'])) {
    $id_inventario = mysqli_real_escape_string($enlace, $_GET['id_inventario']);
}
if (isset($_GET['producto'])) {
    $producto = mysqli_real_escape_string($enlace, $_GET['producto']);
}

$cantidad_total = 0;

$inventario = $controlador->eliminar($id_inventario);

    $obtener = $controlador->obtener($producto);

    foreach ($obtener as $registro) {
        if (isset($registro['cantidad'])) {
            $cantidad_total += $registro['cantidad'];
        }
    }


    $actu = $controlador->actualizar($producto, $cantidad_total);


header("location: ../inventario.php");

?>