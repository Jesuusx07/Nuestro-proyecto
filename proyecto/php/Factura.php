<?php

class Factura {
    private $db;

    public $id_Hventa;
    public $id_pla;
    public $id_pago;
    public $total_factura_ConImpuestos;
    public $responsable;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertar() {
        $sql = "CALL insertar_factura(?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación: " . $this->db->error);
        }

        $stmt->bind_param(
            "iiids", 
            $this->id_Hventa,
            $this->id_pla,
            $this->id_pago,
            $this->total_factura_ConImpuestos,
            $this->responsable
        );

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error al ejecutar el procedimiento: " . $stmt->error);
            return false;
        }
    }
}
?>