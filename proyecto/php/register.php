<?php

require_once 'SessionManager.php'; 
require_once 'sql.php'; // Contiene la conexión a la base de datos $enlace

$session = new SessionManager(); 

// 1. Obtener los datos del formulario (usando ?? '' para evitar errores si no se envían)
// Los nombres de las variables ($_POST['nombre'], etc.) deben coincidir con los atributos 'name'
// de los inputs en tu formulario HTML (registrarse.html).
$nom = $_POST['nombre'] ?? '';
$pass = $_POST['pass'] ?? '';
$email = $_POST['email'] ?? '';
$apell = $_POST['apellido'] ?? '';

// 2. Hashear la contraseña antes de cualquier validación de longitud o caracteres.
//    Esto asegura que siempre trabajas con el hash si decides guardar temporalmente,
//    y la longitud de la contraseña original no es la misma que la del hash.
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// 3. Definir las longitudes mínimas y máximas y otros criterios para la contraseña.
$longMin = 8;
$longMax = 40; // Esta longitud se aplica a la contraseña en texto plano, no al hash.
$longMaxnom = 20; // Longitud máxima para nombres y apellidos.

// 4. Validaciones de los datos recibidos.
//    Se usan `empty()` para verificar si los campos están vacíos.
if(empty($nom) || empty($pass) || empty($email) || empty($apell)){
    $mensaje = "Todos los campos son obligatorios. Por favor, rellénalos.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Validación de longitud máxima para apellido.
else if(strlen($apell) > $longMaxnom){
    $mensaje = "La longitud máxima para el apellido son 20 caracteres.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
<<<<<<< HEAD
// Validación de longitud máxima para nombre.
=======
else if(strpos($apell, " ") !== false){
        $mensaje = "El apellido no puede contener espacios es blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
>>>>>>> 169d9edd2b89c796ea374226b66873d121f8211d
else if(strlen($nom) > $longMaxnom){
    $mensaje = "La longitud máxima para el nombre son 20 caracteres.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
<<<<<<< HEAD
// Validación de longitud mínima para la contraseña.
=======
else if(strpos($nom, " ") !== false){
        $mensaje = "El nombre no puede contener espacios es blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
>>>>>>> 169d9edd2b89c796ea374226b66873d121f8211d
else if(strlen($pass) < $longMin){
    $mensaje = "La contraseña necesita mínimo 8 caracteres.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Validación de longitud máxima para la contraseña.
else if(strlen($pass) > $longMax){
    $mensaje = "La longitud máxima de la contraseña son 40 caracteres.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Validación de mayúscula en la contraseña.
else if(!preg_match('/[A-Z]/', $pass)){
    $mensaje = "La contraseña necesita al menos una letra mayúscula.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Validación de minúscula en la contraseña.
else if(!preg_match('/[a-z]/', $pass)){
    $mensaje = "La contraseña necesita al menos una letra minúscula.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Validación de número en la contraseña.
else if(!preg_match('/[0-9]/', $pass)){
    $mensaje = "La contraseña necesita al menos un número.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Validación de espacios en blanco en la contraseña.
else if(strpos($pass, " ") !== false){
    $mensaje = "La contraseña no debe contener espacios en blanco.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $mensaje . "');"; 
    echo "window.history.back();"; 
    echo "</script>";
    exit; 
}
// Si todas las validaciones pasan...
else {
    // 5. Verificar si el correo ya está registrado en la base de datos.
    // ***MEJORA DE SEGURIDAD Y PREVENCIÓN DE INYECCIÓN SQL:***
    // Se utiliza una sentencia preparada (prepared statement) para evitar inyección SQL.
    // Esto es muy importante cuando insertas datos recibidos del usuario.
    $stmt = $enlace->prepare("SELECT correo FROM admin WHERE correo = ?");
    // 's' indica que el parámetro es de tipo string (cadena).
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $result = $stmt->get_result();
    $user_email = $result->fetch_assoc();
    
    // Si se encontró un correo, significa que ya está registrado.
    if($user_email){ // Cambiado de $email_bd == $email a simplemente verificar $user_email
        $mensaje = "Este correo ya está registrado. Por favor, utiliza otro.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
    // Si el correo no está registrado, procede con la inserción.
    else {
        // 6. Insertar los datos del nuevo administrador en la base de datos.
        // ***CORRECCIÓN CRÍTICA:*** Nombres de columnas actualizados según tu BDD:
        // 'nombres', 'apellidos', 'correo', 'contraseña'.
        // 'null' para 'id_admin' (AUTO_INCREMENT), 'reset_token', 'reset_token_expires_at'.
        // ***MEJORA DE SEGURIDAD Y PREVENCIÓN DE INYECCIÓN SQL:***
        // Se utiliza otra sentencia preparada para la inserción.
        $insertar_query = "INSERT INTO admin (nombres, apellidos, correo, contraseña, reset_token, reset_token_expires_at) VALUES (?, ?, ?, ?, NULL, NULL)";
        $stmt_insert = $enlace->prepare($insertar_query);
        // 'ssss' indica que los 4 parámetros son de tipo string.
        $stmt_insert->bind_param("ssss", $nom, $apell, $email, $pass_hash);
        
        $ejecutarInsertar = $stmt_insert->execute();

        if ($ejecutarInsertar) {
            $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
            echo "<script type='text/javascript'>";
            echo "alert('" . $mensaje . "');"; 
            echo "window.location.href = '../login.php'"; 
            echo "</script>";
            exit;
        } else {
            // Manejo de error si la inserción falla (por ejemplo, problema con la base de datos)
            $mensaje = "Error al registrar el usuario. Por favor, inténtalo de nuevo.";
            error_log("Error al insertar usuario: " . $stmt_insert->error); // Registra el error en los logs del servidor
            echo "<script type='text/javascript'>";
            echo "alert('" . $mensaje . "');"; 
            echo "window.history.back();"; 
            echo "</script>";
            exit;
        }
    }
}
// Cierre de la conexión a la base de datos (Buena práctica).
mysqli_close($enlace);

?>