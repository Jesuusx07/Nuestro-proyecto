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
    public $reset_token;
    public $reset_token_expires_at; 


    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar() {
        $query = "CALL insertar_admin(:nombres, :apellidos, :correo, :contraseña)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombres', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellido);
        $stmt->bindParam(':correo', $this->email);
        $stmt->bindParam(':contraseña', $this->contraseña);
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