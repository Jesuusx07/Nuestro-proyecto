<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'Producto.php';
require_once 'Usuario.php';

$db = (new Database())->conectar();
$controlador = new ProductoController($db);
$controlador2 = new UsuarioController($db);

$id_inventario = $_POST["id_inventario"];
$nombre = $_POST["nombre"];
$categoria = $_POST["categoria"];
$imagen = $_POST["imagen"];
$precio = $_POST["precio"];
$usuario = $_POST["proveedor"];

$producto = $controlador->obtener($nombre);
$proveedor = $controlador2->obtener($usuario);


if($id_inventario == "" || $categoria == "" || $nombre == "" || $imagen == "" || $precio == "" || $usuario == "" ){
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
    elseif($proveedor['id_rol'] == 'proveedor'){
        $proveedor = $proveedor['id_usuario'];
    }
    else{
        if($select == "Fruta"){
            $producto = $controlador->insertar($nombre, "Fruta",  $imagen, $precio, $proveedor);

            header('Location: ../inventarioRegister.php'); 
            exit();
        }
        elseif($select == "Vegetal"){
            $producto = $controlador->insertar($nombre, "Vegetal",  $imagen, $precio, $proveedor);

            header('Location: ../inventarioRegister.php'); 
            exit();
        }    
        elseif($select == "Salsa"){
            $producto = $controlador->insertar($nombre, "Salsa",  $imagen, $precio, $proveedor);

            header('Location: ../inventarioRegister.php'); 
            exit();
        }

    }


}

?>