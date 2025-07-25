<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

$session = new SessionManager();

require_once '../Controlador/InventarioController.php';

$db = (new Database())->conectar();
$controlador = new InventarioController($db);

if (isset($_GET['id_inventario'])) {
    $id_inventario = mysqli_real_escape_string($enlace, $_GET['id_inventario']);
}
if (isset($_GET['producto'])) {
    $producto = mysqli_real_escape_string($enlace, $_GET['producto']);
}

$producto = trim($producto);
$id_inventario = trim($id_inventario);

$cantidad_total = 0;

$obtener = $controlador->obtener($producto);


foreach ($obtener as $fila) {
    if (isset($fila['id_inventario']) && $fila['id_inventario'] == $id_inventario) {
        $fila_id = $fila;
        break;
    }
}

if ($fila_id['cantidad'] > 0){
    if($fila_id['cantidad_total'] - $fila_id['cantidad'] < 0){
        $session->set('error_message', 'No se puede eliminar este registro.');
        header('Location: ../Modelo/inventario.php');
        exit();
    }
}

$inventario = $controlador->eliminar($id_inventario);

$obtener = $controlador->obtener($producto);

foreach ($obtener as $registro) {
    if (isset($registro['cantidad'])) {
        $cantidad_total += $registro['cantidad'];        
    }
}

$inventario = $controlador->actualizar($producto, $cantidad_total);

header('Location: ../Modelo/inventario.php');

?>