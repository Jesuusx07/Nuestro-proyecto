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

if ($fila['cantidad'] > 0){
    if($fila['cantidad_total'] - $fila['cantidad'] < 0){
        $session->set('error_message', 'No se puede eliminar este registro.');
        header('Location: ../inventario.php');
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

$actu = $controlador->actualizar($producto, $cantidad_total);

header('Location: ../inventario.php');

?>