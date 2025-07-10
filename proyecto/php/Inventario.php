<?php

require_once 'sql.php';

class Inventario {
    private $conn;
    private $tabla = "inventario";
    
    public $id;
    public $id_producto;
    public $cantidad;
    public $fecha;
    

    public function __construct($db) {
        $this->conn = $db;
    }


    public function insertar() {
        $query = "CALL insertar_inventario(?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->id_producto);
        $stmt->bindParam(2, $this->cantidad);
        $stmt->bindParam(2, $this->fecha);

        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_inventario(?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->id_producto);
        $stmt->bindParam(3, $this->cantidad);
        $stmt->bindParam(3, $this->fecha);
    
        return $stmt->execute();
    }


    public function obtener() {
        $query = "CALL obtener_inventario(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        $query = "CALL eliminar_inventario(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}