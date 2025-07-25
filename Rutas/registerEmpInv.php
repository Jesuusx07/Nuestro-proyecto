<?php

require_once '../Config/SessionManager.php';
require_once 'sql.php';
require_once 'InventarioController.php';

$session = new SessionManager();
$db = (new Database())->conectar();
$controlador = new InventarioController($db);

// Captura de datos del formulario
$producto = $_POST["producto"];
$cantidad = $_POST["cantidad"];
$imagen = $_POST["imagen"];
$tipo = $_POST["tipo"]; // entrada o salida
$fecha = $_POST["date"];
$responsable = $_POST["responsable"]; // Asegúrate que esto se guarda al iniciar sesión

// Validaciones
$longMin = 8;
$longMax = 50;
if (
    empty($cantidad) || empty($tipo) ||
    empty($fecha) || empty($responsable)
) {
    $session->set('error_message', 'Por favor, complete todos los campos obligatorios.');
    header('Location: ../registerEmpInv.php');
    exit();
}
else if(strlen($producto) > $longMax){
    $session->set('error_message', 'La longitud maxima para el nombre son 50 caracteres.');

    header('Location: ../registrarseEmInv.php'); 
    exit();
}
else if(strlen($producto) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../registerEmpInv.php'); 
    exit();
}
// Validación extra: cantidad numérica y dentro de rango
if (!is_numeric($cantidad) || $cantidad < 1 || $cantidad > 100) {
    $session->set('error_message', 'La cantidad debe estar entre 1 y 100.');
    header('Location: ../registerEmpInv.php');
    exit();
}

// Registro del movimiento en inventario
$resultado = $controlador->insertar(
    $producto,
    $cantidad,
    $imagen,
    $tipo,
    $fecha,
    $responsable
);

// Redirección si fue exitoso
if ($resultado) {
    header('Location: ../inventarioEmp.php');
    exit();
} else {
    $session->set('error_message', 'Error al registrar en inventario.');
    header('Location: ../registerEmpInv.php');
    exit();
}
?>
