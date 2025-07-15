<?php

require_once 'SessionManager.php';
require_once 'sql.php'; // Asumiendo que este archivo contiene la clase Database con conexión PDO

$session = new SessionManager();

require_once 'PlatilloController.php'; // Usamos el controlador de Platillos

// Conectar a la base de datos
try {
    $db = (new Database())->conectar();
} catch (PDOException $e) {
    // Si hay un error de conexión, guarda el mensaje y redirige a una página de error
    $session->set('error_message', 'Error de conexión a la base de datos: ' . $e->getMessage());
    header('Location: ../error.php'); // Puedes crear una página de error genérica
    exit();
}

// Instanciar el PlatilloController
$controlador = new PlatilloController($db);

// Obtener datos del formulario POST para el platillo
// Usamos el operador null coalescing (?? '') para evitar advertencias si una variable no está definida
$id_pla = $_POST["id_producto"] ?? ''; // Asumo que el campo se llama id_producto en el formulario
$nombre = $_POST["nombre"] ?? '';
$descripcion = $_POST["descripcion"] ?? ''; // Nuevo campo para la descripción
$precio = $_POST["precio"] ?? ''; // Cambiado de precio_unitario a precio
$pla_categoria = $_POST["categoria"] ?? ''; // Cambiado de categoria a pla_categoria

// --- Validaciones de Entrada ---
if (empty($id_pla) || empty($nombre) || empty($descripcion) || empty($precio) || empty($pla_categoria)) {
    $session->set('error_message', 'Por favor, llene todos los campos obligatorios.');

    // Redirigir de vuelta a la página de edición con los datos para que el usuario no los pierda
    // Asegúrate de que 'editarProdEmp.php' (o tu página de edición de platillos)
    // espere estos parámetros GET para rellenar el formulario.
    header('Location: ../editarProdEmp.php?' .
           'id_pla=' . urlencode($id_pla) .
           '&nombre=' . urlencode($nombre) .
           '&descripcion=' . urlencode($descripcion) .
           '&precio=' . urlencode($precio) .
           '&pla_categoria=' . urlencode($pla_categoria));
    exit();
} else {
    // Si todas las validaciones básicas pasan, procedemos a actualizar

    // Llamar al método 'actualizar' del controlador de platillos
    // Asegúrate de que tu método 'actualizar' en PlatilloController
    // acepte estos 5 parámetros en este orden: ID, Nombre, Descripcion, Precio, Categoria.
    $actualizado = $controlador->actualizar(
        $id_pla,
        $nombre,
        $descripcion,
        $precio,
        $pla_categoria
    );

    // --- Manejo del Resultado de la Actualización ---
    if ($actualizado) {
        $session->set('success_message', 'Platillo actualizado exitosamente.'); // Mensaje de éxito
        header('Location: ../platlloEmp.php'); // Redirigir a la página de listado de platillos
        exit();
    } else {
        $session->set('error_message', 'Error al actualizar el platillo. Intente de nuevo.');
        // Si la actualización falla en la base de datos, redirige de vuelta con los datos
        header('Location: ../editarPlaEmp.php?' .
               'id_pla=' . urlencode($id_pla) .
               '&nombre=' . urlencode($nombre) .
               '&descripcion=' . urlencode($descripcion) .
               '&precio=' . urlencode($precio) .
               '&pla_categoria=' . urlencode($pla_categoria));
        exit();
    }
}
?>