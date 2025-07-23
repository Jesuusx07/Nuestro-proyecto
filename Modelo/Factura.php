<?php

require_once '../Config/sql.php';

class Factura {
   private $conn;
    private $tabla = "factura"; // Nombre de tu tabla

    public $id_venta;
    public $total_factura_ConImpuestos;
    public $responsable;
    public $metodo_pago;

    public function __construct($db) {
        $this->conn = $db;
    }

  public function insertar() {
        $query = "CALL insertar_factura(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id_venta);
        $stmt->bindParam(2, $this->total_factura_ConImpuestos);
        $stmt->bindParam(3, $this->responsable);
        $stmt->bindParam(4, $this->metodo_pago);       
        return $stmt->execute();
    }
     }
?>