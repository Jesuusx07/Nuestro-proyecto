<?php
    
require_once '../Modelo/Factura.php';

class FacturaController {
    private $factura;

    public function __construct($db) {
        $this->factura = new Factura($db);
    }

    public function insertar($id_venta, $total_factura_ConImpuestos, $responsable, $metodo_pago) {
        $this->factura->id_venta = $id_venta;
        $this->factura->total_factura_ConImpuestos = $total_factura_ConImpuestos;
        $this->factura->responsable = $responsable;
        $this->factura->metodo_pago = $metodo_pago;

        return $this->factura->insertar();
    }

    // Puedes agregar más funciones si quieres actualizar, eliminar o consultar facturas
}
?>