<?php
// php/login.php

require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();

// 1. Obtener los datos del formulario de manera segura (con ?? '' para evitar errores).
$user_email = $_POST['correo'] ?? '';
$user_password = $_POST['contra'] ?? '';

// 2. Validación inicial: campos vacíos.
    if (empty($user_email) || empty($user_password)) {

        $session->set('error_message', 'Por favor, ingresa tu correo electrónico y contraseña.');

        header('Location: ../login.php'); 
        exit();
    } 

// 3. Intentar autenticar como ADMINISTRADOR.
// Prepara la consulta para buscar en la tabla 'admin'.
$stmt_admin = $enlace->prepare("SELECT id_admin, contraseña FROM admin WHERE correo = ?");
$stmt_admin->bind_param("s", $user_email);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result(); // Obtiene el resultado de la consulta.

// Si se encontró un administrador con ese correo...
if ($result_admin->num_rows === 1) {
    $admin_data = $result_admin->fetch_assoc(); // Obtiene los datos del administrador.
    $stored_hash = $admin_data['contraseña']; // Obtiene la contraseña hasheada.

    // Verifica si la contraseña ingresada coincide con la hasheada.
    if (password_verify($user_password, $stored_hash)) {
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
$stmt_empleado = $enlace->prepare("SELECT id_empleado, correo, contraseña FROM empleado WHERE correo = ?"); // Asegúrate de que 'id_empleado' sea el nombre correcto del ID.
$stmt_empleado->bind_param("s", $user_email);
$stmt_empleado->execute();
$result_empleado = $stmt_empleado->get_result();

// Si se encontró un empleado con ese correo...
if ($result_empleado->num_rows === 1) {
    $emple_data = $result_empleado->fetch_assoc(); // Obtiene los datos del empleado.
    $stored_hash_emple = $emple_data['contraseña']; // Obtiene la contraseña hasheada del empleado.

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