<?php
require_once 'Venta.php';

class VentaController {
    private $venta;

    public function __construct($db) {
        $this->venta = new Venta($db);
    }

    public function insertar($id_pla, $cantidad, $precio_total) {
        $this->venta->id_pla = $id_pla;
        $this->venta->cantidad = $cantidad;
        $this->venta->precio_total = $precio_total;

        return $this->venta->insertar();
    }


public function obtenerTodos() {
    return $this->venta->obtenerTodos();
}
   }