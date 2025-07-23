<?php

$servidor = "151.106.96.29";
$usuario = "u112415144_kenny"; 
$clave = "Kennys12345";
$baseDatos = "u112415144_proyecto_kenny";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDatos);

class Database {
    private $host = "151.106.96.29";
    private $db_name = "u112415144_proyecto_kenny";
    private $username = "u112415144_kenny";
    private $password = "Kennys12345";
    public $conn;

    public function conectar() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name",
                                  $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}


?>