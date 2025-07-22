<?php

require_once 'sql.php';

class Factura {
   private $conn;
    private $tabla = "factura"; // Nombre de tu tabla

    public $id_Hventa;
    public $id_pla;
    public $id_pago;
    public $total_factura_ConImpuestos;
    public $responsable;

    public function __construct($db) {
        $this->conn = $db;
    }

  public function insertar() {
        $query = "CALL insertar_factura(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id_Hventa);
        $stmt->bindParam(2, $this->id_pla);
        $stmt->bindParam(3, $this->id_pago);
        $stmt->bindParam(4, $this->total_factura_ConImpuestos);
        $stmt->bindParam(5, $this->responsable);        
        return $stmt->execute();
    }
     }
?>