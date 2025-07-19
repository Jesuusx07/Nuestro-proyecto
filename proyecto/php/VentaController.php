<?php
require_once 'Venta.php';

class VentaController {
    private $venta;

    public function __construct($db) {
        $this->venta = new Venta($db);
    }

    public function insertar($id_pla, $cantidad) {
        $this->venta->id_pla = $id_pla;
        $this->venta->cantidad = $cantidad;

        return $this->venta->insertar();
    }

    // Métodos opcionales según lo que necesites (actualizar, obtener, eliminar)
    // pero si no usas esos procedimientos, puedes eliminarlos o comentarlos:

    /*
    public function actualizar($id, $fecha, $total_venta) {
        $this->venta->id = $id;
        $this->venta->fecha = $fecha;
        $this->venta->total_venta = $total_venta;

        return $this->venta->actualizar();
    }

    public function obtener($id) {
        $this->venta->id = $id;
        return $this->venta->obtener();
    }

    public function eliminar($id) {
        $this->venta->id = $id;
        return $this->venta->eliminar();
    }
    */
}
