<?php

require_once 'SessionManager.php';
require_once 'sql.php';
require_once 'InventarioController.php';

$session = new SessionManager();
$db = (new Database())->conectar();
$controlador = new InventarioController($db);

// Captura de datos del formulario
$producto = $_POST["producto"];
$cantidad = $_POST["cantidad"];
$tipo = $_POST["tipo"]; // entrada o salida
$fecha = $_POST["date"];
$responsable = $session->getUserName();

$longMin = 8;
$longMax = 50;
// Validaciones
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

// Registro del movimiento en inventario

$resultado = $controlador->insertar(
    $producto,
    $cantidad,
    $tipo,
    $fecha,
    $responsable,
    0
);

$cantidad_total_sumada = 0;

$obtener = $controlador->obtener($producto);

foreach ($obtener as $registro) {
        if (isset($registro['cantidad'])) {
            $cantidad_total_sumada += $registro['cantidad'];
        }
    }

var_dump($cantidad_total_sumada);


$actu = $controlador->actualizar($producto, echo $cantidad_total_sumada);

// Redirección si fue exitoso
if ($resultado) {

    exit();
} else {
    $session->set('error_message', 'Error al registrar en inventario.');
    header('Location: ../inventarioRegis.php');
    exit();
}
?>
