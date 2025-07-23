<?php

require_once 'sql.php';

class Usuario {
    private $conn;
    private $tabla = "usuarios";
    
    public $id;
    public $idRol;
    public $nombre;
    public $apellido;
    public $email;
    public $contraseña;
    public $telefono;
    public $documento;
    public $token;
    public $date_token;


    public function __construct($db) {
        $this->conn = $db;
    }


    public function insertar() {
        $query = "CALL insertar_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->idRol);
        $stmt->bindParam(2, $this->nombre);
        $stmt->bindParam(3, $this->apellido);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $this->contraseña);
        $stmt->bindParam(6, $this->telefono);
        $stmt->bindParam(7, $this->documento);
        $stmt->bindParam(8, $this->token);
        $stmt->bindParam(9, $this->date_token);
        return $stmt->execute();
    }

    public function actualizar() {
        $query = "CALL actualizar_usuario(?, ?, ? ,? ,? ,? ,? ,?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->idRol);
        $stmt->bindParam(3, $this->nombre);
        $stmt->bindParam(4, $this->apellido);
        $stmt->bindParam(5, $this->email);
        $stmt->bindParam(6, $this->telefono);
        $stmt->bindParam(7, $this->documento);
        $stmt->bindParam(8, $this->token);
        $stmt->bindParam(9, $this->date_token);
        return $stmt->execute();
    }


    public function obtener() {
        $query = "CALL obtener_usuario(:correo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $this->email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDocu() {
        $query = "CALL obtener_documento(:documento)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':documento', $this->documento);
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