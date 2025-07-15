<?php

require_once 'SessionManager.php'; // Asegúrate de que tu clase SessionManager esté bien definida
require_once 'sql.php';            // Asegúrate de que tu clase Database esté bien definida y conecta

$session = new SessionManager();

require_once 'PlatilloController.php'; // Cambiado a PlatilloController

// Conectar a la base de datos
$db = (new Database())->conectar();
// Instanciar el PlatilloController
$controlador = new PlatilloController($db);

// Obtener datos del formulario POST
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"]; // Nuevo campo para la descripción
$precio = $_POST["precio"];
$select = $_POST["select"]; // Esto será pla_categoria

// Inicializar $platillo a null para evitar errores si no se encuentra
$platillo = null;
// Intentar obtener un platillo por nombre para verificar si ya existe
// IMPORTANTE: Tu método 'obtener' en Platillo.php actualmente busca por ID.
// Si quieres buscar por nombre aquí, necesitarás modificar el método 'obtener' en tu clase Platillo
// o crear un nuevo método, por ejemplo, 'obtenerPorNombre($nombre)'.
// Por ahora, asumiré que 'obtener' podría adaptarse o que 'nombre' es único y se usará como referencia.
// Si 'obtener' solo busca por ID, esta lógica de duplicidad por nombre no funcionará como se espera.
// Para esta validación, sería mejor tener un método 'existePlatilloPorNombre($nombre)' en tu modelo Platillo.
try {

    $platillo_existente = $controlador->obtener($nombre); // Esto podría dar problemas si 'obtener' solo busca por ID.
                                                       // Considera crear un método `obtenerPorNombre` en Platillo.
} catch (Exception $e) {
    // Manejo de errores si la base de datos o el modelo fallan en la obtención
    $session->set('error_message', 'Error al verificar platillo existente: ' . $e->getMessage());
    header('Location: ../registrarPlatilloEmp.php');
    exit();
}


// Validaciones de entrada
if (empty($nombre) || empty($descripcion) || empty($precio) || empty($select)) {
    $session->set('error_message', 'Por favor, llene todos los campos.');
    header('Location: ../registrarPlatilloEmp.php');
    exit();
} else {
    // Validar que el nombre no contenga números
    if (preg_match('/[0-9]/', $nombre)) {
        $session->set('error_message', 'El nombre del platillo no debe contener números.');
        header('Location: ../registrarPlatilloEmp.php');
        exit();
    }
    // Validar si el platillo ya está registrado (asumiendo que $platillo_existente contiene algo si existe)
    // De nuevo, esta validación asume que `obtener($nombre)` o un método similar te devuelve un platillo existente por su nombre.
    // Si $platillo_existente es verdadero, significa que se encontró un registro.
    else if ($platillo_existente) {
        $session->set('error_message', 'Este platillo ya está registrado.');
        header('Location: ../registrarPlatilloEmp.php');
        exit();
    } else {
        // Asignar la categoría y realizar la inserción
        // No hay necesidad de un if/elseif para la categoría si $select ya tiene el valor correcto
        $categoria = $select; // La categoría es lo que viene en $select

        // Insertar el platillo
        $insertado = $controlador->insertar($nombre, $descripcion, $precio, $categoria);

        if ($insertado) {
            // Redirigir al éxito
            header('Location: ../platilloEmp.php');
            exit();
        } else {
            // Manejar error de inserción
            $session->set('error_message', 'Error al registrar el platillo. Intente de nuevo.');
            header('Location: ../registrarPlatilloEmp.php');
            exit();
        }
    }
}

?>