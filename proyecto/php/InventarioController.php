<?php
require_once 'Inventario.php';

class InventarioController {
    private $inventario;

    public function __construct($db) {
        $this->inventario = new Inventario($db);
    }


    public function insertar($producto, $cantidad, $tipo_de_movimiento, $fecha, $responsable, $cantidad_total) {
        $this->inventario->fecha = $fecha;
        $this->inventario->producto = $producto;
        $this->inventario->cantidad = $cantidad;
        $this->inventario->tipo_de_movimiento = $tipo_de_movimiento; 
        $this->inventario->responsable = $responsable; 
        $this->inventario->cantidad_total = $cantidad_total;         

        return $this->inventario->insertar();
    }

    public function actualizar($producto, $cantidad_total) {
        $this->inventario->producto = $producto;
        $this->inventario->cantidad_total = $cantidad_total;

       
        return $this->inventario->actualizar();
    }


    public function obtener($producto) {
        $this->inventario->producto = $producto;
        return $this->inventario->obtener();
    }

    public function eliminar($id_inventario) {
        $this->inventario->id_inventario = $id_inventario;
        return $this->inventario->eliminar();
    }
    
}