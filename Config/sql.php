<?php

$servidor = "kennys.online";
$usuario = "root"; 
$clave = "";
$baseDatos = "u112415144_proyecto_kenny";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDatos);

class Database {
    private $host = "kennys.online";
    private $db_name = "u112415144_proyecto_kenny";
    private $username = "root";
    private $password = "";
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