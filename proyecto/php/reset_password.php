<?php
// reset_password.php
session_start();
require 'sql.php'; // Incluye tu archivo de conexión a la base de datos con mysqli

$message = '';
$token_valid = false;
$user_id = null;
$user_table = '';
$user_id_column = '';
$token_received = '';

if (isset($_GET['token'])) {
    $token_received = $_GET['token'];

    // --- Buscar en la tabla 'admin' ---
    $stmt_admin = mysqli_prepare($enlace, 'SELECT id_admin, correo FROM admin WHERE reset_token = ? AND reset_token_expires_at > NOW()');
    mysqli_stmt_bind_param($stmt_admin, 's', $token_received);
    mysqli_stmt_execute($stmt_admin);
    $result_admin = mysqli_stmt_get_result($stmt_admin);
    if (mysqli_num_rows($result_admin) > 0) {
        $user = mysqli_fetch_assoc($result_admin);
        $user_table = 'admin';
        $user_id_column = 'id_admin';
    }
    mysqli_stmt_close($stmt_admin);

    // --- Si no se encuentra en 'admin', buscar en la tabla 'empleado' ---
    if (!$user) {
        $stmt_empleado = mysqli_prepare($enlace, 'SELECT id_empleado, correo FROM empleado WHERE reset_token = ? AND reset_token_expires_at > NOW()');
        mysqli_stmt_bind_param($stmt_empleado, 's', $token_received);
        mysqli_stmt_execute($stmt_empleado);
        $result_empleado = mysqli_stmt_get_result($stmt_empleado);
        if (mysqli_num_rows($result_empleado) > 0) {
            $user = mysqli_fetch_assoc($result_empleado);
            $user_table = 'empleado';
            $user_id_column = 'id_empleado';
        }
        mysqli_stmt_close($stmt_empleado);
    }

    if ($user) {
        $token_valid = true;
        $user_id = $user[$user_id_column];
    } else {
        $message = 'El token de recuperación no es válido o ha expirado. Por favor, solicita uno nuevo.';
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
    $token_received = $_POST['token'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- Doble verificación del token en el POST por seguridad ---
    $stmt_admin = mysqli_prepare($enlace, 'SELECT id_admin, correo FROM admin WHERE reset_token = ? AND reset_token_expires_at > NOW()');
    mysqli_stmt_bind_param($stmt_admin, 's', $token_received);
    mysqli_stmt_execute($stmt_admin);
    $result_admin = mysqli_stmt_get_result($stmt_admin);
    if (mysqli_num_rows($result_admin) > 0) {
        $user = mysqli_fetch_assoc($result_admin);
        $user_table = 'admin';
        $user_id_column = 'id_admin';
    }
    mysqli_stmt_close($stmt_admin);

    if (!$user) {
        $stmt_empleado = mysqli_prepare($enlace, 'SELECT id_empleado, correo FROM empleado WHERE reset_token = ? AND reset_token_expires_at > NOW()');
        mysqli_stmt_bind_param($stmt_empleado, 's', $token_received);
        mysqli_stmt_execute($stmt_empleado);
        $result_empleado = mysqli_stmt_get_result($stmt_empleado);
        if (mysqli_num_rows($result_empleado) > 0) {
            $user = mysqli_fetch_assoc($result_empleado);
            $user_table = 'empleado';
            $user_id_column = 'id_empleado';
        }
        mysqli_stmt_close($stmt_empleado);
    }

    if ($user) {
        $token_valid = true; // Mantener el formulario abierto si el token sigue siendo válido
        $user_id = $user[$user_id_column];

        if ($new_password !== $confirm_password) {
            $message = 'Las contraseñas no coinciden.';
        } else if (strlen($new_password) < 8) { // Validación básica de longitud mínima
            $message = 'La contraseña debe tener al menos 8 caracteres.';
        } else {
            // Hashear la nueva contraseña de forma segura
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Actualizar la contraseña y limpiar el token en la tabla correspondiente
            $update_query = "UPDATE {$user_table} SET contraseña = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE {$user_id_column} = ?";
            $stmt_update = mysqli_prepare($enlace, $update_query);
            mysqli_stmt_bind_param($stmt_update, 'ssi', $hashed_password, $user[$user_id_column]); // 'ssi' para string, string, integer
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            $message = 'Tu contraseña ha sido restablecida exitosamente. Ahora puedes iniciar sesión.';
            $token_valid = false; // Ya no se necesita el formulario de restablecimiento
            // Opcional: Redirigir al usuario a la página de inicio de sesión
            // header('Location: login.html'); // O la página de login.php si usas PHP para login
            // exit();
        }
    } else {
        $message = 'El token de recuperación no es válido o ha expirado. Por favor, solicita uno nuevo.';
    }
} else {
    $message = 'Acceso inválido al restablecimiento de contraseña.';
}

// Cerrar la conexión a la base de datos al final del script
mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 400px; width: 100%; text-align: center; }
        h2 { color: #333; margin-bottom: 20px; }
        input[type="password"], input[type="submit"] { width: calc(100% - 20px); padding: 12px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ddd; font-size: 16px; }
        input[type="submit"] { background-color: #007bff; color: white; cursor: pointer; border: none; font-weight: bold; transition: background-color 0.3s ease; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .message { color: green; margin-bottom: 15px; font-weight: bold; }
        .error { color: red; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <?php if (!empty($message)): ?>
            <p class="<?php echo (strpos($message, 'exitosamente') !== false) ? 'message' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <?php if ($token_valid): ?>
            <form action="reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token_received); ?>">
                <label for="password" style="display: block; text-align: left; margin-bottom: 8px; color: #555;">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password" style="display: block; text-align: left; margin-bottom: 8px; color: #555;">Confirmar Nueva Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <input type="submit" value="Restablecer Contraseña">
            </form>
        <?php elseif (empty($message)): ?>
            <p class="error">Token de recuperación no proporcionado o inválido.</p>
        <?php endif; ?>
    </div>
</body>
</html>