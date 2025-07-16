<?php
require_once 'Inventario.php';

class InventarioController {
    private $Inventario;

    public function __construct($db) {
        $this->inventario = new Inventario($db);
    }


    public function insertar($producto, $cantidad, $imagen, $movimiento, $fecha, $responsable) {
        $this->inventario->fecha = $fecha;
        $this->inventario->producto = $producto;
        $this->inventario->cantidad = $cantidad;
        $this->inventario->imagen = $imagen;
        $this->inventario->movimiento = $movimiento; 
        $this->inventario->responsable = $responsable; 

        return $this->inventario->insertar();
    }

    public function actualizar($id, $fecha, $total_inventario) {
        $this->inventario->id = $id;
        $this->inventario->fecha = $fecha;
        $this->inventario->total_inventario = $total_inventario;
       
        return $this->inventario->actualizar();
    }


    public function obtener($id) {
        $this->inventario->id = $id;
        return $this->inventario->obtener();
    }

    public function eliminar($id) {
        $this->inventario->id = $id;
        return $this->inventario->eliminar();
    }
}