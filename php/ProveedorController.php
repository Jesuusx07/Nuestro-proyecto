<?php

require_once 'prveedor.php';

class ProveedorController {
    private $proveedor;

    public function __construct($db) {
        $this->proveedor = new proveedor($db);
    }


    public function insertar($id_proveedor, $id_usuario, $producto, $cantidad) {
        $this->proveedor->nombre = $id_proveedor;
        $this->proveedor->categoria = $id_usuario;
        $this->proveedor->imagen = $producto;
        $this->proveedor->precio = $cantidad;

        return $this->proveedor->insertar();
    }

    public function actualizar($id_proveedor, $producto, $cantidad) {
        $this->proveedor->id = $id_proveedor;
        $this->proveedor->nombre = $producto;
        $this->proveedor->categoria = $cantidad;
        return $this->producto->actualizar();
    }


    public function obtener($id) {
        $this->producto->id = $id;
        return $this->producto->obtener();
    }

    public function eliminar($id) {
        $this->producto->id = $id;
        return $this->producto->eliminar();
    }
}