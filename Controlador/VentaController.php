<?php
require_once 'Venta.php';

class VentaController {
    private $venta;

    public function __construct($db) {
        $this->venta = new Venta($db);
    }

    /**
     * Inserta una nueva venta con platillo, cantidad, total y fecha
     */
    public function insertar($id_pla, $cantidad, $precio_total, $fecha) {
        $this->venta->id_pla = $id_pla;
        $this->venta->cantidad = $cantidad;
        $this->venta->precio_total = $precio_total;
        $this->venta->fecha = $fecha;

        return $this->venta->insertar();
    }

    /**
     * Obtiene todas las ventas registradas
     */
    public function obtenerTodos() {
        return $this->venta->obtenerTodos();
    }
}
