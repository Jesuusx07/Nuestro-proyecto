<?php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'InventarioController.php';

$db = (new Database())->conectar();
$controlador = new InventarioController($db);

$id_inventario = $_POST["id_inventario"];
$tipo = $_POST["tipo"];
$cantidad = $_POST["cantidad"];

$longMin = 8;
$longMax = 50;

if($tipo == "" || $cantidad == ""){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../editar_inventario.php?id_inventario=' . $id_inventario . '&tipo=' . $tipo . '&cantidad=' . $cantidad);

    exit();
}
elseif (!is_numeric($cantidad) || $cantidad < 1 || $cantidad > 100) {
    $session->set('error_message', 'La cantidad debe estar entre 1 y 100.');
header('Location: ../editar_inventario.php?id_inventario=' . $id_inventario . '&tipo=' . $tipo . '&cantidad=' . $cantidad);
    exit();
}


    else{
        if($tipo == "entrada"){

            $inventario = $controlador->actualizar_datos($id_inventario, $cantidad, "entrada");

            header('Location: ../inventario.php'); 
            exit();
        }       

        elseif($tipo == "salida"){

            $cantidad = -$cantidad;

            $inventario = $controlador->actualizar_datos($id_inventario, $cantidad, "salida");

            header('Location: ../inventario.php'); 
            exit();
        }
}


?>