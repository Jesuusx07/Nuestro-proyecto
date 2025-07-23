<?php

<<<<<<< HEAD
$servidor = "localhost";
=======
$servidor = "u112415144_proyecto_kenny";
>>>>>>> e6b91b034f0953817e795169e0a699f8ea5c90fb

$usuario = "u112415144_Kennys"; 

$clave = "Kennys12345";

$baseDatos = "u112415144_proyecto_kenny";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDatos);

class Database {
<<<<<<< HEAD
    private $host = "localhost";
=======
    private $host = "u112415144_proyecto_kenny";
>>>>>>> e6b91b034f0953817e795169e0a699f8ea5c90fb
    private $db_name = "u112415144_proyecto_kenny";
    private $username = "u112415144_Kennys";
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
