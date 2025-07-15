<?php
require_once 'Platillo.php'; // Asegúrate de que esta ruta sea correcta para tu modelo Platillo

class PlatilloController {
    private $platillo;

    public function __construct($db) {
        // Instancia el modelo Platillo, asumiendo que recibe una conexión a la base de datos
        $this->platillo = new Platillo($db);
    }

    public function insertar($nombre, $descripcion, $precio, $pla_categoria) {
        $this->platillo->nombre = $nombre;
        $this->platillo->descripcion = $descripcion;
        $this->platillo->precio = $precio;
        $this->platillo->pla_categoria = $pla_categoria;

        return $this->platillo->insertar();
    }

    public function actualizar($id_pla, $nombre, $descripcion, $precio, $pla_categoria) {
        $this->platillo->id_pla = $id_pla; // Establece el ID para la operación de actualización
        $this->platillo->nombre = $nombre;
        $this->platillo->descripcion = $descripcion;
        $this->platillo->precio = $precio;
        $this->platillo->pla_categoria = $pla_categoria;

        return $this->platillo->actualizar();
    }

    public function obtener($id_pla) {
        $this->platillo->id_pla = $id_pla; // Establece el ID para la operación de recuperación
        return $this->platillo->obtener();
    }

    public function eliminar($id_pla) {
        $this->platillo->id_pla = $id_pla; // Establece el ID para la operación de eliminación
        return $this->platillo->eliminar();
    }
}