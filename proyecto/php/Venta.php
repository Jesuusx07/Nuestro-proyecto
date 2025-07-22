<?php

require_once 'sql.php'; // Asegúrate de que sql.php devuelve $enlace o conexión PDO

class Venta {
    private $conn;

    public $id_pla;
    public $cantidad;
    public $precio_total;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar() {
    $query = "CALL registrar_venta(?, ?, ?)";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        die("Error en prepare: " . $this->conn->error);
    }

    $stmt->bind_param("iid", $this->id_pla, $this->cantidad, $this->precio_total); // i: int, d: double

    try {
        return $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        error_log("Error al insertar venta: " . $e->getMessage());
        return false;
    }
}


public function obtenerTodos() {
    try {
        // Preparar la consulta al procedimiento almacenado
        $query = "CALL obtener_todas_las_ventas()";
        $stmt = $this->conn->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener todos los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar el cursor para liberar conexión
        $stmt->closeCursor();

        return $resultados;

    } catch (PDOException $e) {
        return ['error' => $e->getMessage()];
    }
}
}

