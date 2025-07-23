<?php

require_once '../Modelo/Producto.php';

class ProductoController{
    private $producto;

    public function __construct($db) {
        $this->producto = new Producto($db);
    }


    public function insertar($nombre, $categoria, $imagen, $precio, $proveedor) {
        $this->producto->nombre = $nombre;
        $this->producto->categoria = $categoria;
        $this->producto->imagen = $imagen;
        $this->producto->precio = $precio;
        $this->producto->proveedor = $proveedor;        

        return $this->producto->insertar();
    }

    public function actualizar($id, $nombre, $categoria, $imagen, $precio) {
        $this->producto->id = $id;
        $this->producto->nombre = $nombre;
        $this->producto->categoria = $categoria;
        $this->producto->imagen = $imagen;
        $this->producto->precio = $precio;

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