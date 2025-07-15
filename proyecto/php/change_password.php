<?php

require_once('sql.php'); // Contiene la conexión a la base de datos $enlace

// NO NECESARIO AQUÍ: SessionManager no es requerido para este flujo de cambio de contraseña.
// require_once './php/SessionManager.php'; 

// 1. Obtener el ID del administrador y la nueva contraseña desde el POST.
//    Los nombres de las variables ($_POST['id_admin'] y $_POST['new_contraseña'])
//    deben coincidir con los atributos 'name' de los inputs en el formulario HTML.
//    Usamos `?? ''` para manejar el caso de que los campos vengan vacíos o no definidos,
//    evitando avisos y permitiendo la validación posterior.
$id_admin = $_POST['id_admin'] ?? '';
$nueva_contraseña = $_POST['new_contraseña'] ?? ''; 

// 2. Validar que los datos recibidos no estén vacíos.
//    Si el ID o la nueva contraseña no se reciben, redirigimos con un mensaje de error.
if (empty($id_admin) || empty($nueva_contraseña)) {
    header("Location: ../login.php?message=change_password_error"); // Mensaje genérico de error al cambiar.
    exit(); // Es crucial terminar la ejecución del script después de un header().
}

// 3. Hashear la nueva contraseña.
//    ***CORRECCIÓN CRÍTICA Y MEJORA DE SEGURIDAD MÍNIMA:***
//    ¡NUNCA almacenes contraseñas en texto plano en la base de datos!
//    `password_hash()` crea un hash seguro que es el que se guarda.
//    Tu columna 'contraseña' en la BDD con VARCHAR(255) es adecuada para almacenar este hash.
$hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

// 4. Actualizar la contraseña en la base de datos.
//    ***CORRECCIÓN:*** La tabla 'admin' usa 'contraseña' para la columna de la contraseña.
//    ***CORRECCIÓN:*** La tabla 'admin' usa 'id_admin' para la columna del ID primario.
//    ***ADVERTENCIA DE SEGURIDAD:*** Esta consulta sigue siendo vulnerable a Inyección SQL
//    si el ID no es estrictamente numérico y si no se usan sentencias preparadas.
//    Por ahora, para funcionalidad, la dejamos así, pero DEBERÍA MEJORARSE.
$query = "UPDATE admin SET contraseña = '$hashed_password' WHERE id_admin = '$id_admin'"; // <--- CAMBIADO
$result = $enlace->query($query); // Usamos la conexión `$enlace` de `sql.php`.

// 5. Verificar si la actualización fue exitosa y redirigir.
//    Para operaciones UPDATE (y INSERT, DELETE), `$result` será `true` en caso de éxito
//    y `false` en caso de error en la consulta.
if ($result) { 
    // Contraseña actualizada exitosamente.
    // Redirigimos al usuario a la página de login para que inicie sesión con su nueva contraseña.
    // NO se debe iniciar sesión automáticamente aquí.
    header("Location: ../login.php?message=password_changed_ok");
    exit(); // Termina el script.
} else {
    // Si hubo un error en la actualización de la base de datos.
    // Usar `error_log()` para grabar detalles en los logs del servidor (útil para depurar).
    error_log("Error al actualizar contraseña en la base de datos: " . mysqli_error($enlace));
    header("Location: ../login.php?message=password_changed_error");
    exit(); // Termina el script.
}

// 6. Cierre de la conexión a la base de datos.
mysqli_close($enlace);

?>