<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ProductoController.php';

$db = (new Database())->conectar();
$controlador = new ProductoController($db);

$nombre = $_POST["nombre"];
$imagen = $_POST["imagen"];
$precio = $_POST["precio"];
$select = $_POST["select"];

$producto = $controlador->obtener($nombre);



if($nombre == "" || $imagen == "" || $precio == "" || $select == "" ){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../registrarProducto.php'); 
    exit();
}
else{
    if(preg_match('/[0-9]/', $nombre)){
        $session->set('error_message', 'El nombre no debe contener numeros.');

        header('Location: ../registrarProducto.php');
        exit(); 
    }
    else if($producto){
        $session->set('error_message', 'Este producto ya esta registrado.');

        header('Location: ../registrarProducto.php');
    }
    else{
        if($select == "Fruta"){
            $producto = $controlador->insertar($nombre, "Fruta",  $imagen, $precio);

            header('Location: ../producto.php'); 
            exit();
        }
        elseif($select == "Vegetal"){
            $producto = $controlador->insertar($nombre, "Vegetal",  $imagen, $precio);

            header('Location: ../producto.php'); 
            exit();
        }    
        elseif($select == "Salsa"){
            $producto = $controlador->insertar($nombre, "Salsa",  $imagen, $precio);

            header('Location: ../producto.php'); 
            exit();
        }

    }


}

?>