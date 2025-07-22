<?php
    
require_once 'Factura.php';

class FacturaController {
    private $factura;

    public function __construct($db) {
        $this->factura = new Factura($db);
    }

    public function insertar($id_Hventa, $id_pla, $id_pago, $total_factura_ConImpuestos, $responsable) {
        $this->factura->id_Hventa = $id_Hventa;
        $this->factura->id_pla = $id_pla;
        $this->factura->id_pago = $id_pago;
        $this->factura->total_factura_ConImpuestos = $total_factura_ConImpuestos;
        $this->factura->responsable = $responsable;

        return $this->factura->insertar();
    }

    // Puedes agregar más funciones si quieres actualizar, eliminar o consultar facturas
}
?>