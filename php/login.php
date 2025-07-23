<?php
// php/login.php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

// 1. Obtener los datos del formulario de manera segura (con ?? '' para evitar errores).
$user_email = $_POST['correo'] ?? '';
$user_password = $_POST['contra'] ?? '';

// 2. Validación inicial: campos vacíos.
    if ($user_email == "" || $user_password == "") {

        $session->set('error_message', 'Por favor, ingresa tu correo electrónico y contraseña.');

        header('Location: ../login.php'); 
        exit();
    } 

// 3. Intentar autenticar como ADMINISTRADOR.
// Prepara la consulta para buscar en la tabla 'admin'.
$usuario = $controlador->obtener($user_email);


// Si se encontró un administrador con ese correo...
if ($usuario) {
    $stored_hash = $usuario['contraseña']; // Obtiene la contraseña hasheada.

    // Verifica si la contraseña ingresada coincide con la hasheada.
    if (password_verify($user_password, $stored_hash) && $usuario['id_rol'] == 'admin') {
        // Autenticación exitosa como administrador.
        // Asume que el rol '1' es para administradores.
        $session->login(1, $user_email); // Puedes pasar $admin_data['id_admin'] si tu SessionManager lo espera.
        header("location: ../dashboard.php");
        exit();
    }
}

// 4. Si NO es administrador O la contraseña de admin no coincidió, intentar autenticar como EMPLEADO.
// Prepara la consulta para buscar en la tabla 'empleado'.
// ¡Asegúrate de que la tabla 'empleado' también tenga la columna 'contraseña' y 'correo' para que esto funcione!
$usuario = $controlador->obtener($user_email);

// Si se encontró un empleado con ese correo...
if ($usuario) {
    $stored_hash_emple = $usuario['contraseña']; // Obtiene la contraseña hasheada del empleado.

    // Verifica si la contraseña ingresada coincide con la hasheada para empleado.
    if (password_verify($user_password, $stored_hash_emple)) {
        // Autenticación exitosa como empleado.
        // Asume que el rol '2' es para empleados.
        $session->login(2, $user_email); // Puedes pasar $emple_data['id_empleado'] si tu SessionManager lo espera.
        header("location: ../dashboardEmp.php");
        exit();
    }
}

// 5. Si no se autenticó en ninguna de las tablas (credenciales inválidas o usuario no encontrado).
// Redirige al login con un mensaje de error genérico para seguridad (no dice si el usuario existe o no).
$session->set('error_message', 'Credenciales invalidas.');

header('Location: ../login.php'); 
exit();

// Cierre de la conexión a la base de datos (Buena práctica).
mysqli_close($enlace);

?>