<?php

require_once '../Config/SessionManager.php';
require_once '../Config/sql.php'; // Asumiendo que este archivo contiene la clase Database con conexión PDO

$session = new SessionManager();

require_once '../Controlador/PlatilloController.php'; // Usamos el controlador de Platillos

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
$controlador = new PlatilloController($db); // Se añadió esta línea para instanciar el controlador

// Inicializar variables para los campos del formulario
// Usamos el operador null coalescing (?? '') para evitar advertencias si una variable no está definida

$id_pla = $_GET['id_pla'] ?? '';
$nombre = $_GET['nombre'] ?? '';
$descripcion = $_GET['descripcion'] ?? '';
$precio = $_GET['precio'] ?? '';
$pla_categoria = $_GET['pla_categoria'] ?? '';

// Nota: 'imagen' ya no es una columna en la tabla platillo, así que no se recupera ni se usa aquí.

// --- Código PHP para procesar el formulario POST ---
// Este bloque se añadió para manejar la lógica de actualización cuando el formulario se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario POST para el platillo
    $id_pla_post = $_POST["id_pla"] ?? ''; // Corregido: Coincide con el name del input hidden
    $nombre_post = $_POST["nombre"] ?? '';
    $descripcion_post = $_POST["descripcion"] ?? '';
    $precio_post = $_POST["precio"] ?? '';
    $pla_categoria_post = $_POST["pla_categoria"] ?? ''; // Corregido: Coincide con el name del select

    // --- Validaciones de Entrada ---
    if (empty($id_pla_post) || empty($nombre_post) || empty($descripcion_post) || empty($precio_post) || empty($pla_categoria_post)) {
        $session->set('error_message', 'Por favor, llene todos los campos obligatorios.');

        // Redirigir de vuelta a la página de edición con los datos para que el usuario no los pierda
        header('Location: ../Rutas/editarPlatillo.php?' .
               'id_pla=' . urlencode($id_pla_post) .
               '&nombre=' . urlencode($nombre_post) .
               '&descripcion=' . urlencode($descripcion_post) .
               '&precio=' . urlencode($precio_post) .
               '&pla_categoria=' . urlencode($pla_categoria_post));
        exit();
    } else {
        // Si todas las validaciones básicas pasan, procedemos a actualizar

        // Llamar al método 'actualizar' del controlador de platillos
        // Asegúrate de que tu método 'actualizar' en PlatilloController
        // acepte estos 5 parámetros en este orden: ID, Nombre, Descripcion, Precio, Categoria.
        $actualizado = $controlador->actualizar(
            $id_pla_post,
            $nombre_post,
            $descripcion_post,
            $precio_post,
            $pla_categoria_post
        );

        // --- Manejo del Resultado de la Actualización ---
        if ($actualizado) {
            $session->set('success_message', 'Platillo actualizado exitosamente.'); // Mensaje de éxito
            header('Location: ../Vista/platilloAdmin.php'); // Redirigir a la página de listado de platillos
            exit();
        } else {
            $session->set('error_message', 'Error al actualizar el platillo. Intente de nuevo.');
            // Si la actualización falla en la base de datos, redirige de vuelta con los datos
            header('Location: ../Vista/editarPlatillo.php?' .
                   'id_pla=' . urlencode($id_pla_post) .
                   '&nombre=' . urlencode($nombre_post) .
                   '&descripcion=' . urlencode($descripcion_post) .
                   '&precio=' . urlencode($precio_post) .
                   '&pla_categoria=' . urlencode($pla_categoria_post));
            exit();
        }
    }
}