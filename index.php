<?php
require_once 'sql.php';
require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

// Crear nuevo usuario

// Obtener usuario con ID 1
$usuario = $controlador->obtener("danieldmejias@gmail.com");

if($usuario["nombres"] == "daniel"){
    include 'usuario_view.php';
}

// Mostrar usuario


// Descomenta para actualizar el usuario
// $controlador->actualizar(1, "Carlos Editado", "nuevo@example.com");

// Descomenta para eliminar el usuario
// $controlador->eliminar(1);