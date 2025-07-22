<?php

require_once 'SessionManager.php';
require_once 'sql.php';
require_once 'InventarioController.php';

$session = new SessionManager();
$db = (new Database())->conectar();
$controlador = new InventarioController($db);


$producto = $_POST["producto"];
$cantidad = $_POST["cantidad"];
$tipo = $_POST["tipo"]; // entrada o salida
$fecha = $_POST["date"];
$responsable = $session->getUserName();

$longMin = 8;
$longMax = 50;

$obtener = $controlador->obtener($producto);

$zonaHorariaBogota = new DateTimeZone('America/Bogota');
$ahora = new DateTime('now', $zonaHorariaBogota);

$format = 'Y-m-d\TH:i';

$nuevaFecha = DateTime::createFromFormat($format, $fecha, $zonaHorariaBogota); 


$fila1 = $obtener[0];


if (
    $cantidad == "" || $tipo == "" ||
    $fecha == "" || $producto == ""
) {
    $session->set('error_message', 'Por favor, complete todos los campos obligatorios.');
    header('Location: ../inventarioRegis.php');
    exit();
}

// Validación extra: cantidad numérica y dentro de rango
if (!is_numeric($cantidad) || $cantidad < 1 || $cantidad > 100) {
    $session->set('error_message', 'La cantidad debe estar entre 1 y 100.');
    header('Location: ../inventarioRegis.php');
    exit();
}    
if($nuevaFecha < $ahora) {
    $session->set('error_message', 'No se puede registrar una fecha y hora anterior al momento actual.');
    header('Location: ../inventarioRegis.php');
    exit();
}

$cantidad_total = 0;

if($tipo == "entrada") {

    $cantidad = $cantidad;
    
} 
else if ($tipo == "salida") {

    if($fila1['cantidad_total'] < $cantidad) {
        $session->set('error_message', 'No hay suficiente inventario para realizar esta salida.');
        header('Location: ../inventarioRegis.php');
        exit();
    } 

    $cantidad = -$cantidad;

}

if ($cantidad_total == 0){
    $cantidad_total = $cantidad;
}
// Registro del movimiento en inventario

$resultado = $controlador->insertar(
    $producto,
    $cantidad,
    $tipo,
    $fecha,
    $responsable,
    $cantidad_total
);


    foreach ($obtener as $registro) {
        if (isset($registro['cantidad'])) {
            $cantidad_total += $registro['cantidad'];
        }
    }



$actu = $controlador->actualizar($producto, $cantidad_total);

// Redirección si fue exitoso
if ($resultado) {
    header('Location: ../inventario.php');
    exit();
} else {
    $session->set('error_message', 'Error al registrar en inventario.');
    header('Location: ../inventarioRegis.php');
    exit();
}
?>
