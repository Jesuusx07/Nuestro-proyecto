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

$longMin = 8;
$longMax = 50;

if($nombre == "" || $imagen == "" || $precio == "" || $select == "" ){
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
    else if(strlen($nom) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
else if(strlen($pass) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
    else if($producto){
        $session->set('error_message', 'Este producto ya esta registrado.');

        header('Location: ../registerEmpPro.php');
    }
    else{
        if($select == "Fruta"){
            $producto = $controlador->insertar($nombre, "Fruta",  $imagen, $precio);

            header('Location: ../productosEmp.php'); 
            exit();
        }
        elseif($select == "Vegetal"){
            $producto = $controlador->insertar($nombre, "Vegetal",  $imagen, $precio);

            header('Location: ../productosEmp.php'); 
            exit();
        }    
        elseif($select == "Salsa"){
            $producto = $controlador->insertar($nombre, "Salsa",  $imagen, $precio);

            header('Location: ../productosEmp.php'); 
            exit();
        }

    }


}

?>