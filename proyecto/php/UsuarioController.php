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

    public function actualizar($id, $nombre, $email) {
        $this->usuario->id = $id;
        $this->usuario->nombre = $nombre;
        $this->usuario->email = $email;
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