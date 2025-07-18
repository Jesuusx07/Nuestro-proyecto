<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'ProductoController.php';

$db = (new Database())->conectar();
$controlador = new ProductoController($db);

$id_producto = $_POST["id_producto"];
$nombre = $_POST["nombre"];
$imagen = $_POST["imagen"];
$imagen1 = $_POST["imagen1"];
$precio_unitario = $_POST["precio"];
$categoria = $_POST["categoria"];
$longMin = 8;
$longMax = 50;

if($nombre == "" || $precio_unitario == "" || $categoria == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../editarProEmp.php?id=' . $id_producto . '&categoria=' . $categoria . ' &nombre=' . $nombre . '&imagen=' . $imagen1 . '&precio_unitario=' . $precio_unitario); 

    exit();
}
else{
    if($imagen == ""){
        $imagen = $imagen1;
    }
        if($categoria == "Fruta"){
            $producto = $controlador->actualizar($id_producto, $nombre, 'Fruta', $imagen, $precio_unitario);

            header('Location: ../productosEmp.php'); 
            exit();
        }
        else if(strlen($nom) > $longMax){
    $session->set('error_message', 'La longitud maxima para el nombre son 50 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
else if(strlen($pass) < $longMin){
    $session->set('error_message', 'La longitud maxima para el nombre son 50 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
        elseif($categoria == "Salsa"){
            $producto = $controlador->actualizar($id_producto, $nombre, 'Salsa', $imagen, $precio_unitario);
            header('Location: ../productosEmp.php'); 
            exit();
        }    
        elseif($categoria == "Vegetal"){
            $producto = $controlador->actualizar($id_producto, $nombre, 'Vegetal', $imagen, $precio_unitario);

            header('Location: ../productosEmp.php'); 
            exit();
        }

    }

?>