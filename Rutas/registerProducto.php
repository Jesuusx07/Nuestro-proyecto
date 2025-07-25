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
    else if(strlen($nombre) > $longMax){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../registrarProducto.php'); 
    exit();
    }
    else{
        if($categoria == "Fruta"){
            $producto = $controlador->insertar($nombre, "Fruta",  $imagen, $precio, $proveedor);

            header('Location: ../Vista/producto.php'); 
            exit();
        }
        elseif($categoria == "Vegetal"){
            $producto = $controlador->insertar($nombre, "Vegetal",  $imagen, $precio, $proveedor);

            header('Location: ../Vista/producto.php'); 
            exit();
        }    
        elseif($categoria == "Salsa"){
            $producto = $controlador->insertar($nombre, "Salsa",  $imagen, $precio, $proveedor);

            header('Location: ../Vista/producto.php'); 
            exit();
        }
 
    elseif ($categoria == "Carne") {
        $producto = $controlador->insertar($nombre, "Carne", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Pollo") {
        $producto = $controlador->insertar($nombre, "Pollo", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Pescado y Mariscos") {
        $producto = $controlador->insertar($nombre, "Pescado y Mariscos", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Cereal y Harinas") {
        $producto = $controlador->insertar($nombre, "Cereal y Harinas", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Lácteo") {
        $producto = $controlador->insertar($nombre, "Lácteo", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Bebida") {
        $producto = $controlador->insertar($nombre, "Bebida", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Postre") {
        $producto = $controlador->insertar($nombre, "Postre", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Panadería") {
        $producto = $controlador->insertar($nombre, "Panadería", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Aceites y Grasas") {
        $producto = $controlador->insertar($nombre, "Aceites y Grasas", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Especias y Condimentos") {
        $producto = $controlador->insertar($nombre, "Especias y Condimentos", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Congelados") {
        $producto = $controlador->insertar($nombre, "Congelados", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Enlatados") {
        $producto = $controlador->insertar($nombre, "Enlatados", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Limpieza") {
        $producto = $controlador->insertar($nombre, "Limpieza", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Desechables") {
        $producto = $controlador->insertar($nombre, "Desechables", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    } elseif ($categoria == "Otros") {
        $producto = $controlador->insertar($nombre, "Otros", $imagen, $precio, $proveedor);
        header('Location: ../Vista/producto.php');
        exit();
    }
}

    }



?>