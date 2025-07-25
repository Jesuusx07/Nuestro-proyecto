<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

$session = new SessionManager();

require_once 'ProductoController.php';
require_once 'UsuarioController.php';

$db = (new Database())->conectar();

$controlador = new ProductoController($db);

$controlador2 = new UsuarioController($db);

$nombre = $_POST["nombre"];
$categoria = $_POST["select"];
$imagen = $_POST["imagen"];
$precio = $_POST["precio"];
$usuario = $_POST["proveedor"];

$producto = $controlador->obtener($nombre);
$proveedor = $controlador2->obtener($usuario);

$proveedor = $proveedor['id_usuario'];

$longMin = 8;
$longMax = 50;


var_dump($usuario);

if($nombre == "" || $categoria == "" || $imagen == "" || $precio == "" || $usuario == ""){

    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../registerEmpPro.php');

    exit();
}
else{
    if(preg_match('/[0-9]/', $nombre)){
        $session->set('error_message', 'El nombre no debe contener numeros.');

        header('Location: ../registerEmpPro.php');
        exit(); 
    }
    else if($producto){
        $session->set('error_message', 'Este producto ya esta registrado.');

        header('Location: ../registerEmpPro.php');
    }
    else if(strlen($nombre) > $longMax){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../registerEmpPro.php'); 
    exit();
    }
    else{
        if($categoria == "Fruta"){
            $producto = $controlador->insertar($nombre, "Fruta",  $imagen, $precio, $proveedor);

            header('Location: ../productosEmp.php'); 
            exit();
        }
        elseif($categoria == "Vegetal"){
            $producto = $controlador->insertar($nombre, "Vegetal",  $imagen, $precio, $proveedor);

            header('Location: ../productosEmp.php'); 
            exit();
        }    
        elseif($categoria == "Salsa"){
            $producto = $controlador->insertar($nombre, "Salsa",  $imagen, $precio, $proveedor);

            header('Location: ../productosEmp.php'); 
            exit();
        }

    }


}

?>