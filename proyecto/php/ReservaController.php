<?php
require_once 'Reserva.php';

class ReservaController {
    private $reserva;

    public function __construct($db) {
        $this->reserva = new Reserva($db);
    }


    public function insertar($estado, $fecha) {
        $this->reserva->estado = $estado;
        $this->reserva->fecha = $fecha;


        return $this->reserva->insertar();
    }

    public function actualizar($id, $estado, $fecha) {
        $this->reserva->id = $id;
        $this->reserva->estado = $estado;
        $this->reserva->fecha = $fecha;

        return $this->reserva->actualizar();
    }


    public function obtener($id) {
        $this->reserva->id = $id;
        return $this->reserva->obtener();
    }

    public function eliminar($id) {
        $this->reserva->id = $id;
        return $this->reserva->eliminar();
    }
}