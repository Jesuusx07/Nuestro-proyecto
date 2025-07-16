<?php
require_once 'Inventario.php';

class InventarioController {
    private $Inventario;

    public function __construct($db) {
        $this->inventario = new Inventario($db);
    }


    public function insertar($fecha, $total_inventario) {
        $this->inventario->fecha = $fecha;
        $this->inventario->total_inventario = $total_inventario;

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