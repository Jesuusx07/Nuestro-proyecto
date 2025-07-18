<?php
require_once 'Inventario.php';

class InventarioController {
    private $Inventario;

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
        $this->inventario->id = $producto;
        $this->inventario->cantidad_total = $cantidad_total;

       
        return $this->inventario->actualizar();
    }


    public function obtener($id) {
        $this->inventario->id = $id;
        return $this->inventario->obtener();
    }

    public function actualizar_datos($id, $cantidad, $tipo_de_movimiento) {
        $this->inventario->id = $id;
        $this->inventario->cantidad = $cantidad;
        $this->inventario->tipo_de_movimiento = $tipo_de_movimiento;         
        return $this->inventario->actualizar_datos();
    }
    
}