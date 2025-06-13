<?php

require_once 'sql.php';

class Usuario {
    private $conn;
    private $tabla = "usuarios";

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $contraseña;
    public $token;
    public $date_token;


    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar() {
        $query = "CALL insertar_admin(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->apellido);
        $stmt->bindParam(3, $this->email);
        $stmt->bindParam(4, $this->contraseña);
        $stmt->bindParam(5, $this->token);
        $stmt->bindParam(6, $this->date_token);
        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_usuario(:id, :nombre, :email)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        return $stmt->execute();
    }

    public function obtener() {
        $query = "CALL obtener_admin(:correo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $this->email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerEmp() {
        $query = "CALL obtener_empleado(:correo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $this->email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        $query = "CALL eliminar_usuario(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}