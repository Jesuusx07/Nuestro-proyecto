<?php

require_once '../Config/sql.php'; // Asegúrate de que este archivo maneje la conexión a la base de datos PDO

class Inventario {
    private $conn;
    private $tabla = "inventario";

    // Propiedades de la clase que corresponden a las columnas de la tabla
    public $id_inventario;
    public $producto;
    public $cantidad;
    public $cantidad_total;
    public $tipo_de_movimiento; 
    public $fecha;
    public $responsable;    
    
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Inserta un nuevo registro de inventario en la base de datos.
     * Corresponde al procedimiento almacenado 'insertar_inventario'.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function insertar() {
        // La consulta llama al procedimiento almacenado con 6 parámetros
        $query = "CALL insertar_inventario(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        // Limpiar y enlazar los parámetros para prevenir inyección SQL
        // Los tipos de datos deben coincidir con los de la tabla y el SP
        $stmt->bindParam(1, $this->producto);
        $stmt->bindParam(2, $this->cantidad, PDO::PARAM_INT); // Especificar tipo INT
        $stmt->bindParam(3, $this->tipo_de_movimiento); // <-- Ahora enlaza la propiedad correctamente
        $stmt->bindParam(4, $this->fecha); // Formato YYYY-MM-DD
        $stmt->bindParam(5, $this->responsable); // Especificar tipo INT
        $stmt->bindParam(6, $this->cantidad_total); // Especificar tipo INT        

        // Ejecutar la consulta
        return $stmt->execute();
    }

    /**
     * Actualiza un registro existente en la tabla inventario.
     * Corresponde al procedimiento almacenado 'actualizar_inventario'.
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function actualizar() {
        // La consulta llama al procedimiento almacenado con 2 parámetros
        $query = "CALL actualizar_inventario(?, ?)";
        $stmt = $this->conn->prepare($query);
        
        // Limpiar y enlazar los parámetros
        $stmt->bindParam(1, $this->producto); // ID del registro a actualizar
        $stmt->bindParam(2, $this->cantidad_total);

        // Ejecutar la consulta
        return $stmt->execute();
    }

    /**
     * Obtiene un único registro de inventario por su ID.
     * Corresponde al procedimiento almacenado 'obtener_inventario'.
     * @return array|false Un array asociativo con los datos del registro, o false si no se encuentra.
     */
    public function obtener() {
        // Usar marcadores de posición con nombre es una buena práctica
        $query = "CALL obtener_inventario(:producto)";
        $stmt = $this->conn->prepare($query);
        
        // Enlazar el ID de inventario
        $stmt->bindParam(':producto', $this->producto);
        
        $stmt->execute();
        // Devolver el resultado como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un registro de inventario por su ID.
     * Corresponde al procedimiento almacenado 'eliminar_inventario'.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function eliminar() {
        // Usar marcadores de posición con nombre
        $query = "CALL eliminar_inventario(:id_inventario)";
        $stmt = $this->conn->prepare($query);
        // Enlazar el ID de inventario
        $stmt->bindParam(':id_inventario', $this->id_inventario);
        // Ejecutar la consulta
        return $stmt->execute();
    }
}