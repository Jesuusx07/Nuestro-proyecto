<?php

require_once 'sql.php';

class Proveedor {
    private $conn;
    private $tabla = "proveedor";
    public $id_proveedor;
    public $id_usuario;
    public $producto;
    public $cantidad;

    

    public function __construct($db) {
        $this->conn = $db;
    }


    public function insertar() {
        $query = "CALL insertar_proveedor(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->id_proveedor);
        $stmt->bindParam(2, $this->id_usuario);
        $stmt->bindParam(3, $this->producto);
        $stmt->bindParam(4, $this->cantidad);


        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_proveedor(?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_proveedor);
        $stmt->bindParam(3, $this->producto);
        $stmt->bindParam(3, $this->cantidad);
    
        return $stmt->execute();
    }


    public function obtener() {
        $query = "CALL obtener_proveedor(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        $query = "CALL eliminar_proveedor(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}