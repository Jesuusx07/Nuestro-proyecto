<?php
// php/register.php

// 1. Inicia la sesión. Tu SessionManager lo hace, así que no lo repetimos aquí.
//    Si en el futuro cambias SessionManager para no iniciar sesión, deberías añadir:
//    session_start();

require_once 'SessionManager.php';
require_once 'sql.php'; // Este archivo contiene tu conexión $enlace

$session = new SessionManager(); // Instancia SessionManager, que inicia la sesión

<<<<<<< HEAD
// 2. Recuperar datos POST de forma segura y preventiva
//    Uso del operador de coalescencia nula (?? '') para evitar advertencias si un campo no existe
$nom = $_POST['nombre'] ?? '';
$pass = $_POST['pass'] ?? '';
$email = $_POST['correo'] ?? '';
$apell = $_POST['apellido'] ?? '';

// 3. Hasheo de contraseña
//    PASSWORD_DEFAULT es generalmente recomendado ya que se actualiza al algoritmo más fuerte.
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// 4. Validación de campos vacíos y redirección con mensaje de error (Mejor UX)
if (empty($nom) || empty($pass) || empty($email) || empty($apell)) {
    // Redirige al usuario de vuelta al formulario con un parámetro de error
    // para que JavaScript en el frontend pueda mostrar un mensaje.
    header("Location: ../registrarse.html?error=campos_vacios");
    exit; // Termina el script inmediatamente después de la redirección
=======
    $nom = $_POST['nombre'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $apell = $_POST['apellido'];

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $longMin = 8;
    $longMax = 40;
    $longMaxnom = 20;


if($nom == "" || $pass == "" || $email == "" || $apell == ""){
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($apell) > $longMaxnom){
        $mensaje = "La longitud maxima para el apellido son 20 caracteres";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($nom) > $longMaxnom){
        $mensaje = "La longitud maxima para el nombre son 20 caracteres";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($pass) < $longMin){
        $mensaje = "La contraseña necesita minimo 8 caracteres.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strlen($pass) > $longMax){
        $mensaje = "La longitud maxima de caracteres son 40 caracteres.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(!preg_match('/[A-Z]/', $pass)){
        $mensaje = "La contraseña necesita minimo una mayuscula";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(!preg_match('/[a-z]/', $pass)){
        $mensaje = "La contraseña necesita minimo una minuscula";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(!preg_match('/[0-9]/', $pass)){
        $mensaje = "La contraseña necesita minimo un numero";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else if(strpos($pass, " ") !== false){
        $mensaje = "La contraseña no debe contener espacios en blanco";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}

else{
    $stmt = $enlace->prepare("SELECT correo FROM admin WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_email = $result->fetch_assoc();
    $email_bd = $user_email['correo'];

        if($email_bd == $email){
                $mensaje = "Este correo ya esta registrado";
                echo "<script type='text/javascript'>";
                echo "alert('" . $mensaje . "');"; 
                echo "window.history.back();"; 
                echo "</script>";
                exit; 
        }
        else{
                $insertar = "INSERT INTO admin VALUES(null, '$nom', '$apell', '$email', '$pass_hash', null, null)";
                $ejecutarInsertar = mysqli_query($enlace, $insertar);
                $mensaje = "registro exitoso";
                echo "<script type='text/javascript'>";
                echo "alert('" . $mensaje . "');"; 
                echo "window.location.href = '../login.php'"; 
                echo "</script>";
                exit;
        }

>>>>>>> 34670ea7b9130872835bb09e9b7560997137756c
}

// 5. Preparar y ejecutar la consulta SQL usando SENTENCIAS PREPARADAS (¡CRÍTICO PARA LA SEGURIDAD!)
//    Asumimos que la tabla 'admin' tiene columnas: id (AUTO_INCREMENT), nombre, apellido, correo, contrasena_hash.
//    Asegúrate de que los nombres de las columnas en INSERT INTO coincidan con tu tabla 'admin'.
$insertar_sql = "INSERT INTO admin (nombre, apellido, correo, contrasena_hash) VALUES (?, ?, ?, ?)";
7
// Preparar la sentencia
$stmt = mysqli_prepare($enlace, $insertar_sql);

// Verificar si la preparación de la sentencia fue exitosa
if ($stmt === false) {
    // Es crucial registrar estos errores (ej. en un archivo de log)
    // No muestres el error interno de la DB directamente al usuario final en producción.
    error_log("Error al preparar la consulta para el registro de admin: " . mysqli_error($enlace));
    header("Location: ../registrarse.html?error=db_error_prep");
    exit;
}

// Vincular parámetros a la sentencia preparada
// 'ssss' indica que esperamos 4 parámetros de tipo string (s = string)
// El orden debe coincidir con el orden de las columnas en la sentencia INSERT
mysqli_stmt_bind_param($stmt, "ssss", $nom, $apell, $email, $pass_hash);

// Ejecutar la sentencia
if (mysqli_stmt_execute($stmt)) {
    // Registro exitoso: redirige a la página de login con un mensaje de éxito
    header("Location: ../login.html?registro=exitoso");
    exit; // Termina el script inmediatamente
} else {
    // Manejo de errores en la ejecución de la consulta
    // Por ejemplo, error de correo duplicado si la columna 'correo' es UNIQUE en tu tabla 'admin'
    if (mysqli_errno($enlace) == 1062) { // Código de error de MySQL para entrada duplicada
        header("Location: ../registrarse.html?error=correo_duplicado");
    } else {
        // Otro tipo de error en la ejecución
        error_log("Error al ejecutar la consulta para el registro de admin: " . mysqli_stmt_error($stmt));
        header("Location: ../registrarse.html?error=registro_fallido");
    }
    exit;
}

// 6. Cerrar la sentencia preparada
mysqli_stmt_close($stmt);

// 7. Cerrar la conexión a la base de datos (Buena práctica)
mysqli_close($enlace);

?>