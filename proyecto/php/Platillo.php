<?php

require_once 'sql.php'; // Asegúrate de que 'sql.php' contiene tu clase de conexión a la base de datos

class Platillo {
    private $conn;
    private $tabla = "platillo"; // Nombre de tu tabla

    // Propiedades del platillo, que corresponden a las columnas de la tabla
    public $id_pla;
    public $nombre;
    public $descripcion;
    public $precio;
    public $pla_categoria;


    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar() {
        // Asegúrate de que el procedimiento almacenado 'insertar_platillo' existe en tu DB
        // y acepta los parámetros en el orden correcto: nombre, descripcion, precio, pla_categoria
        $query = "CALL insertar_platillo(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos (opcional, pero buena práctica)
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->pla_categoria = htmlspecialchars(strip_tags($this->pla_categoria));

        // Vincular los parámetros
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->descripcion);
        $stmt->bindParam(3, $this->precio);
        $stmt->bindParam(4, $this->pla_categoria);

        return $stmt->execute();
    }

    public function actualizar() {
        // Asegúrate de que el procedimiento almacenado 'actualizar_platillo' existe en tu DB
        // y acepta los parámetros en el orden correcto: id_pla, nombre, descripcion, precio, pla_categoria
        $query = "CALL actualizar_platillo(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->id_pla = htmlspecialchars(strip_tags($this->id_pla));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->pla_categoria = htmlspecialchars(strip_tags($this->pla_categoria));

        // Vincular los parámetros
        $stmt->bindParam(1, $this->id_pla);
        $stmt->bindParam(2, $this->nombre);
        $stmt->bindParam(3, $this->descripcion);
        $stmt->bindParam(4, $this->precio);
        $stmt->bindParam(5, $this->pla_categoria);

        return $stmt->execute();
    }

    public function obtener() {
        // Asegúrate de que el procedimiento almacenado 'obtener_platillo' existe en tu DB
        // y acepta un parámetro para el ID
        $query = "CALL obtener_platillo(:id_platillo)";
        $stmt = $this->conn->prepare($query);

        // Limpiar el ID
        $this->id_pla = htmlspecialchars(strip_tags($this->id_pla));

        // Vincular el ID
        $stmt->bindParam(':id_platillo', $this->id_pla);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar() {
        // Asegúrate de que el procedimiento almacenado 'eliminar_platillo' existe en tu DB
        // y acepta un parámetro para el ID
        $query = "CALL eliminar_platillo(:id_platillo)";
        $stmt = $this->conn->prepare($query);

        // Limpiar el ID
        $this->id_pla = htmlspecialchars(strip_tags($this->id_pla));

        // Vincular el ID
        $stmt->bindParam(':id_platillo', $this->id_pla);

        return $stmt->execute();
    }
}