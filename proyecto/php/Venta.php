<?php

require_once 'sql.php';

class Venta {
    private $conn;
    private $tabla = "venta";
    
    public $id;
    public $fecha;
    public $total_venta;
  


    public function __construct($db) {
        $this->conn = $db;
    }


    public function insertar() {
        $query = "CALL insertar_venta(?, ?)";
        $stmt = $this->conn->prepare($query);
         $stmt->bindParam(1, $this->fecha);
        $stmt->bindParam(1, $this->fecha);
        $stmt->bindParam(2, $this->total_venta);

        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_venta(?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->fecha);
        $stmt->bindParam(3, $this->total_venta);
    
        return $stmt->execute();
    }


    public function obtener() {
        $query = "CALL obtener_venta(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        $query = "CALL eliminar_venta(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}