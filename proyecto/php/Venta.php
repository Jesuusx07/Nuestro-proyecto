<?php

require_once 'sql.php'; // Asegúrate de que sql.php devuelve $enlace o conexión PDO

class Venta {
    private $conn;

    public $id_pla;
    public $cantidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar() {
        $query = "CALL insertar_venta(:id_pla, :cantidad)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_pla', $this->id_pla, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $this->cantidad, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
