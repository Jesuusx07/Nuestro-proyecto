<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

$session = new SessionManager();

require_once '../Controlador/ProductoController.php';

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

    header('Location: ../Rutas/editar_producto.php?id=' . $id_producto . '&categoria=' . $categoria . ' &nombre=' . $nombre . '&imagen=' . $imagen1 . '&precio_unitario=' . $precio_unitario); 

    exit();
}
else{
    if($imagen == ""){
        $imagen = $imagen1;
    }
        if($categoria == "Fruta"){
            $producto = $controlador->actualizar($id_producto, $nombre, 'Fruta', $imagen, $precio_unitario);

            header('Location: ../Vista/producto.php'); 
            exit();
        }
        else if(strlen($nom) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
else if(strlen($pass) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../Vista/registrarse.php'); 
    exit();
}
        elseif($categoria == "Salsa"){
            $producto = $controlador->actualizar($id_producto, $nombre, 'Salsa', $imagen, $precio_unitario);
            header('Location: ../Vista/producto.php'); 
            exit();
        }    
        elseif($categoria == "Vegetal"){
            $producto = $controlador->actualizar($id_producto, $nombre, 'Vegetal', $imagen, $precio_unitario);

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

?>