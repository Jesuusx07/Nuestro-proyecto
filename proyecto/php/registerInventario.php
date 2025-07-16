<?php

require_once 'SessionManager.php';
require_once 'sql.php';
require_once 'InventarioController.php';

$session = new SessionManager();
$db = (new Database())->conectar();
$controlador = new InventarioController($db);

// Captura de datos del formulario
$id_producto = $_POST["id_producto"];
$cantidad = $_POST["cantidad"];
$imagen = $_POST["imagen"];
$tipo = $_POST["tipo"]; // entrada o salida
$fecha = $_POST["fecha"];
$responsable = $_SESSION["id_usuario"]; // Asegúrate que esto se guarda al iniciar sesión

// Validaciones
if (
    empty($id_producto) || empty($cantidad) || empty($tipo) ||
    empty($fecha) || empty($responsable)
) {
    $session->set('error_message', 'Por favor, complete todos los campos obligatorios.');
    header('Location: ../regisinventario.php');
    exit();
}

// Validación extra: cantidad numérica y dentro de rango
if (!is_numeric($cantidad) || $cantidad < 1 || $cantidad > 100) {
    $session->set('error_message', 'La cantidad debe estar entre 1 y 100.');
    header('Location: ../regisinventario.php');
    exit();
}

// Registro del movimiento en inventario
$resultado = $controlador->insertar(
    $id_producto,
    $cantidad,
    $imagen,
    $tipo,
    $fecha,
    $responsable
);

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
