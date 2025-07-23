<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php'; // Asegúrate de que este archivo contiene la clase Database con conexión PDO

$session = new SessionManager();

// Redirige si el usuario no ha iniciado sesión
if (!$session->isLoggedIn()){
    header("location: ../Rutas/login.php");
    exit();
}

// Carga el controlador de Platillos
require_once '../Controlador/PlatilloController.php'; // ¡Ruta corregida!

// Conectar a la base de datos
try {
    $db = (new Database())->conectar();
} catch (PDOException $e) {
    $session->set('error_message', 'Error de conexión a la base de datos: ' . $e->getMessage());
    header('Location: ../Vista/platilloEmp.php'); // Redirige a la página de listado de platillos en caso de error de DB
    exit();
}

// Instanciar el PlatilloController
$controlador = new PlatilloController($db);

// Verificar si se recibió el ID del platillo a eliminar
if (isset($_GET['id_pla'])) { // El ID debe venir como 'id_pla' desde el enlace de eliminar
    $id_platillo = $_GET['id_pla']; // Se obtiene directamente el ID, PDO lo manejará de forma segura
} else {
    $session->set('error_message', 'ID de platillo no proporcionado para eliminar.');
    header('Location: ../Vista/platilloEmp.php'); // Redirige si no hay ID
    exit();
}

// Intentar eliminar el platillo
try {
    $eliminado = $controlador->eliminar($id_platillo);

    if ($eliminado) {
        $session->set('success_message', 'Platillo eliminado exitosamente.');
    } else {
        $session->set('error_message', 'Error al eliminar el platillo. Intente de nuevo.');
    }
} catch (Exception $e) {
    // Captura cualquier excepción durante la eliminación (ej. error de base de datos)
    $session->set('error_message', 'Error al eliminar el platillo: ' . $e->getMessage());
}

// Redirigir de vuelta a la página de listado de platillos
header("location: ../Vista/platilloEmp.php");
exit();

?>