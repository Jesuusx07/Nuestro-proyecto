<?php

require_once 'sql.php';

class Reserva {
    private $conn;
    private $tabla = "reserva";
    
    public $id;
    public $date;
    public $estado;
    public $nombre;
    public $apellido;
    public $usuario;
    public $rol;
    public $correo;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function insertar() {
        $query = "CALL insertar_reserva(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->estado);
        $stmt->bindParam(2, $this->fecha);
        $stmt->bindParam(3, $this->rol);        
        $stmt->bindParam(4, $this->nombre);
        $stmt->bindParam(5, $this->apellido);
        $stmt->bindParam(6, $this->correo);
        $stmt->bindParam(7, $this->usuario);
        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_reserva(?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->estado);
        $stmt->bindParam(3, $this->fecha);
        
        return $stmt->execute();
    }


    public function obtener() {
        $query = "CALL obtener_reserva(:date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':date', $this->date);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        $query = "CALL eliminar_reserva(:id, :cliente)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':cliente', $this->correo);
        return $stmt->execute();
    }
}

