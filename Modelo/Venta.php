<?php

require_once '../Config/sql.php'; // Asegúrate de que este archivo retorna una conexión PDO en $enlace o similar

class Venta {
    private $conn;

    public $id_pla;
    public $cantidad;
    public $precio_total;
    public $fecha;

    public function __construct($db) {
        $this->conn = $db; // MySQLi
    }

    public function insertar() {
    $stmt = $this->conn->prepare("CALL registrar_venta(?, ?, ?, ?)");

    if (!$stmt) {
        error_log("Error preparando la consulta: " . $this->conn->error);
        return false;
    }

    $stmt->bind_param("iids", $this->id_pla, $this->cantidad, $this->precio_total, $this->fecha);
    
    if (!$stmt->execute()) {
        error_log("Error al ejecutar: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $stmt->close();

    // Recuperar el resultado del SELECT LAST_INSERT_ID()
    $result = $this->conn->query("SELECT LAST_INSERT_ID() AS id_venta");
    if ($result && $row = $result->fetch_assoc()) {
        return $row['id_venta']; // ✅ Retorna el ID insertado
    } else {
        error_log("Error al recuperar el ID insertado: " . $this->conn->error);
        return false;
    }
}


    public function obtenerTodos() {
        $resultados = [];
        $result = $this->conn->query("CALL obtener_todas_las_ventas()");

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $resultados[] = $row;
            }
            $result->free();
            $this->conn->next_result(); // Muy importante para liberar el resultado del procedimiento
        } else {
            error_log("Error al obtener ventas: " . $this->conn->error);
        }

        return $resultados;
    }
}

