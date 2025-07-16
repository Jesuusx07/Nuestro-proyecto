<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'Inventario.php';

$db = (new Database())->conectar();
$controlador = new InventarioController($db);

$nombre = $_POST["id_inventario"];
$imagen = $_POST["cantidad"];
$nombre = $_POST["imagen"];
$imagen = $_POST["tipo_de_movimiento"];
$imagen = $_POST["fecha"];
$nombre = $_POST["responsable"];

$producto = $controlador->obtener($nombre);



if($id_inventario == "" || $cantidad == "" || $imagen == "" || $tipo_de_movimiento || $fecha == "" || $responsable == "" ){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../registerInventario.php'); 
    exit();
}
else{
    if(preg_match('/[0-9]/', $nombre)){
        $session->set('error_message', 'El nombre no debe contener numeros.');

        header('Location: ../inventarioRegister.php');
        exit(); 
    }
    else if($producto){
        $session->set('error_message', 'Este producto ya esta registrado.');

        header('Location: ../inventarioRegister.php');
    }
    else{
        if($select == "Fruta"){
            $producto = $controlador->insertar($nombre, "Fruta",  $imagen, $precio);

            header('Location: ../inventarioRegister.php'); 
            exit();
        }
        elseif($select == "Vegetal"){
            $producto = $controlador->insertar($nombre, "Vegetal",  $imagen, $precio);

            header('Location: ../inventarioRegister.php'); 
            exit();
        }    
        elseif($select == "Salsa"){
            $producto = $controlador->insertar($nombre, "Salsa",  $imagen, $precio);

            header('Location: ../inventarioRegister.php'); 
            exit();
        }

    }


}

?>