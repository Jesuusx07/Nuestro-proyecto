<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

$session = new SessionManager();

// Redirige si el usuario no ha iniciado sesión
if (!$session->isLoggedIn()){
    header("location: login.php");
    exit();
}

require_once 'PlatilloController.php'; // Asegúrate de que esta ruta sea correcta

// Conectar a la base de datos
try {
    $db = (new Database())->conectar();
} catch (PDOException $e) {
    $session->set('error_message', 'Error de conexión a la base de datos: ' . $e->getMessage());
    header('Location: ../registrarPlatilloEmp.php');
    exit();
}


// Instanciar el PlatilloController
$controlador = new PlatilloController($db);

// Obtener datos del formulario POST
$nombre = $_POST["nombre"] ?? '';
$descripcion = $_POST["descripcion"] ?? '';
$precio = $_POST["precio"] ?? '';
$pla_categoria = $_POST["pla_categoria"] ?? ''; // ¡CORREGIDO! Ahora coincide con el 'name' del HTML

// Lógica para verificar si el platillo ya existe por nombre
// (Asumiendo que PlatilloController tiene un método obtenerPorNombre($nombre))


// Validaciones de entrada: todos los campos son requeridos
if (empty($nombre) || empty($descripcion) || empty($precio) || empty($pla_categoria)) {

    $session->set('error_message', 'Por favor, llene todos los campos.');
    header('Location: ../registrarPlatillo.php');
    exit();
} else {
    // Validar que el nombre no contenga números
    if (preg_match('/[0-9]/', $nombre)) {
        $session->set('error_message', 'El nombre del platillo no debe contener números.');
        header('Location: ../registrarPlatillo.php');
        exit();
    }
    // Validar si el platillo ya está registrado por nombre

    else if ($platillo_existente) {
        $session->set('error_message', 'Este platillo ya está registrado.');
        header('Location: ../registrarPlatillo.php');
        exit();
    } else {
        // Insertar el platillo utilizando el controlador
        // Los parámetros deben coincidir con el método insertar de PlatilloController
        $insertado = $controlador->insertar($nombre, $descripcion, $precio, $pla_categoria);

        if ($insertado) {
            header('Location: ../platilloAdmin.php'); // Redirigir a la página de éxito o listado
            exit();
        } else {
            // Manejar error de inserción
            $session->set('error_message', 'Error al registrar el platillo. Intente de nuevo.');
            header('Location: ../registrarPlatillo.php');
            exit();
        }
    }
}

?>