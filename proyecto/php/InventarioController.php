<?php
require_once 'venta.php';

class VentaController {
    private $venta;

    public function __construct($db) {
        $this->venta = new Venta($db);
    }


    public function insertar($fecha, $total_venta) {
        $this->venta->fecha = $fecha;
        $this->venta->total_venta = $total_venta;

        return $this->venta->insertar();
    }

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
}