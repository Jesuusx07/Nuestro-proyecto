<?php

require_once 'sql.php';

class Producto {
    private $conn;
    private $tabla = "producto";
    
    public $id;
    public $categoria;
    public $imagen;
    public $precio;
    public $nombre;


    public function __construct($db) {
        $this->conn = $db;
    }


    public function insertar() {
        $query = "CALL insertar_producto(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->categoria);
        $stmt->bindParam(3, $this->imagen);
        $stmt->bindParam(4, $this->precio);
        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_producto(?, ?, ? ,?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->nombre);
        $stmt->bindParam(3, $this->categoria);
        $stmt->bindParam(4, $this->imagen);
        $stmt->bindParam(5, $this->precio);
        return $stmt->execute();
    }


    public function obtener() {
        $query = "CALL obtener_producto(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        $query = "CALL eliminar_producto(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}