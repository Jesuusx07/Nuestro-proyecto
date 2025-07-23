<?php
require_once 'FacturaController.php';
require_once 'VentaController.php';
require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();
$db = (new Database())->conectar();
$controlador1 = new FacturaController($db);
$controlador3 = new VentaController($db);
   
$venta =  $controlador3 -> obtenerTodos();   



$responsable = $session->getUserName();

$ultimoventa = end($venta);

$ultimoIdVenta = $ultimoventa['id_venta'];

$total_venta = $ultimoventa['precio_total'];
$iva = $total_venta * 0.19;
$total_factura_ConImpuestos = $total_venta + $iva;

$Factura = $controlador1->insertar($ultimoIdVenta, $ultimoIdPlatillo, 1, $total_factura_ConImpuestos, $responsable);


if ($Factura) {
    $session->set('success_message', 'Factura registrada correctamente.');
    header("Location: ../GenerarFactura.php?mensaje=ok");
} else {
    $session->set('error_message', 'Error al registrar la factura.');
    header("Location: ../RegistrarFactura.php?error=registro_fallido");
}
?>