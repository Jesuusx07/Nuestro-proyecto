<?php
require_once 'Reserva.php';

class ReservaController {
    private $reserva;

    public function __construct($db) {
        $this->reserva = new Reserva($db);
    }


    public function insertar($estado, $fecha, $rol, $nombre, $apellido, $correo, $usuario) {
        $this->reserva->estado = $estado;
        $this->reserva->fecha = $fecha;
        $this->reserva->nombre = $nombre;
        $this->reserva->apellido = $apellido;
        $this->reserva->usuario = $usuario;
        $this->reserva->rol = $rol;
        $this->reserva->correo = $correo;        


        return $this->reserva->insertar();
    }

    public function actualizar($id, $estado, $fecha) {
        $this->reserva->id = $id;
        $this->reserva->estado = $estado;
        $this->reserva->fecha = $fecha;

        return $this->reserva->actualizar();
    }


    public function obtener($date) {
        $this->reserva->date = $date;   
        return $this->reserva->obtener();
    }

    public function eliminar($id) {
        $this->reserva->id = $id;
        return $this->reserva->eliminar();
    }
}