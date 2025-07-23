<?php

require_once 'sql.php'; // Asegúrate de que este archivo retorna una conexión PDO en $enlace o similar

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
        $resultado = $stmt->execute();

        if (!$resultado) {
            error_log("Error al ejecutar: " . $stmt->error);
        }

        $stmt->close();
        return $resultado;
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

