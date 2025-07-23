<?php
require_once('sql.php'); // Contiene la conexión a la base de datos $enlace

// 1. Obtener el ID del usuario y la nueva contraseña desde el POST.
$id_usuario = $_POST['id_usuario'] ?? '';
$nueva_contraseña = $_POST['new_contraseña'] ?? '';

// 2. Validar que los datos recibidos no estén vacíos.
if (empty($id_usuario) || empty($nueva_contraseña)) {
    header("Location: ../login.php?message=change_password_error");
    exit();
}

// 3. Hashear la nueva contraseña.
$hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

// 4. Actualizar la contraseña en la base de datos.
//    ⚠️ Recomendado: usar consultas preparadas para evitar inyección SQL.
$query = "UPDATE usuario SET contraseña = '$hashed_password' WHERE id_usuario = '$id_usuario'";
$result = $enlace->query($query);

// 5. Verificar si la actualización fue exitosa y redirigir.
if ($result) {
    header("Location: ../login.php?message=password_changed_ok");
    exit();
} else {
    error_log("Error al actualizar contraseña en la base de datos: " . mysqli_error($enlace));
    header("Location: ../login.php?message=password_changed_error");
    exit();
}

// 6. Cierre de la conexión a la base de datos.
mysqli_close($enlace);
?>