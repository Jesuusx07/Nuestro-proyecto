<?php
require_once 'Usuario.php';

class UsuarioController {
    private $usuario;

    public function __construct($db) {
        $this->usuario = new Usuario($db);
    }

    public function insertar($id, $nombre, $apellido, $email, $contraseña, $reset_token, $reset_token_expires_at) {
        $this->usuario->id = $id;
        $this->usuario->nombre = $nombre;
        $this->usuario->apellido = $apellido;
        $this->usuario->email = $email;
        $this->usuario->contraseña = $contraseña;
        $this->usuario->reset_token = $reset_token;
        $this->usuario->reset_token_expires_at = $reset_token_expires_at;
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