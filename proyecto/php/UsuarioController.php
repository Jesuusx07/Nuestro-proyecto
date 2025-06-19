<?php
require_once 'Usuario.php';

class UsuarioController {
    private $usuario;

    public function __construct($db) {
        $this->usuario = new Usuario($db);
    }

    public function insertar($nombre, $apellido, $email, $contraseña, $token, $date_token) {
        $this->usuario->token = $token;
        $this->usuario->date_token = $date_token;
        $this->usuario->nombre = $nombre;
        $this->usuario->apellido = $apellido;
        $this->usuario->email = $email;
        $this->usuario->contraseña = $contraseña;
        return $this->usuario->insertar();
    }

    public function insertarEmp($idRol, $nombre, $apellido, $email, $contraseña, $telefono, $documento, $token, $date_token) {
        $this->usuario->token = $token;
        $this->usuario->date_token = $date_token;
        $this->usuario->idRol = $idRol;
        $this->usuario->telefono = $telefono;
        $this->usuario->documento = $documento;
        $this->usuario->nombre = $nombre;
        $this->usuario->apellido = $apellido;
        $this->usuario->email = $email;
        $this->usuario->contraseña = $contraseña;
        return $this->usuario->insertarEmp();
    }

    public function actualizar($id, $idRol, $nombre, $apellido, $email, $contraseña, $telefono, $documento, $token, $date_token) {
        $this->usuario->id = $id;
        $this->usuario->token = $token;
        $this->usuario->date_token = $date_token;
        $this->usuario->idRol = $idRol;
        $this->usuario->telefono = $telefono;
        $this->usuario->documento = $documento;
        $this->usuario->nombre = $nombre;
        $this->usuario->apellido = $apellido;
        $this->usuario->email = $email;
        $this->usuario->contraseña = $contraseña;
        return $this->usuario->actualizar();
    }

    public function obtener($email) {
        $this->usuario->email = $email;
        return $this->usuario->obtener();
    }

    public function obtenerEmp($email) {
        $this->usuario->email = $email;
        return $this->usuario->obtenerEmp();
    }

    public function eliminar($id) {
        $this->usuario->id = $id;
        return $this->usuario->eliminar();
    }
}