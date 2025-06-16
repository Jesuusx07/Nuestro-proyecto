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
$token = null;
$date = null;

// 2. Hashear la contraseña antes de cualquier validación de longitud o caracteres.
//    Esto asegura que siempre trabajas con el hash si decides guardar temporalmente,
//    y la longitud de la contraseña original no es la misma que la del hash.
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// 3. Definir las longitudes mínimas y máximas y otros criterios para la contraseña.
$longMin = 8;
$longMax = 40; // Esta longitud se aplica a la contraseña en texto plano, no al hash.
$longMaxnom = 20; // Longitud máxima para nombres y apellidos.

require_once 'UsuarioController.php';

$db = (new Database())->conectar();
$controlador = new UsuarioController($db);

// 4. Validaciones de los datos recibidos.
//    Se usan `empty()` para verificar si los campos están vacíos.
if(empty($nom) || empty($pass) || empty($email) || empty($apell)){
    $session->set('error_message', 'Por favor, llene todos los campos.');

    header('Location: ../login.php'); 
    exit();
}
// Validación de longitud máxima para apellido.
else if(strlen($apell) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el apellido son 20 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}

else if(strpos($apell, " ") !== false){
    $session->set('error_message', 'El apellido no puede contener espacios en blanco.');

    header('Location: ../registrarse.php'); 
    exit();
}
else if(preg_match('/[0-9]/', $apell)){
    $session->set('error_message', 'El apellido no debe contener numeros.');

    header('Location: ../registrarse.php');
    exit(); 
}
else if(preg_match('/[0-9]/', $nom)){
    $session->set('error_message', 'El nombre no debe contener numeros.');

    header('Location: ../registrarse.php');
    exit(); 
}
else if(strlen($nom) > $longMaxnom){
    $session->set('error_message', 'La longitud maxima para el nombre son 20 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}

else if(strpos($nom, " ") !== false){
    $session->set('error_message', 'El nombre no puede contener espacios en blanco.');

    header('Location: ../registrarse.php'); 
    exit();
}

else if(strlen($pass) < $longMin){
    $session->set('error_message', 'La contraseña minimo necesita 8 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
// Validación de longitud máxima para la contraseña.
else if(strlen($pass) > $longMax){
    $session->set('error_message', 'La longitud maxima de la contraseña son 40 caracteres.');

    header('Location: ../registrarse.php'); 
    exit();
}
// Validación de mayúscula en la contraseña.
else if(!preg_match('/[A-Z]/', $pass)){
    $session->set('error_message', 'La contraseña necesita al menos una letra mayuscula.');

    header('Location: ../registrarse.php'); 
    exit();
}
// Validación de minúscula en la contraseña.
else if(!preg_match('/[a-z]/', $pass)){
    $session->set('error_message', 'La contraseña necesita al menos una letra minuscula.');

    header('Location: ../registrarse.php'); 
    exit();
}
// Validación de número en la contraseña.
else if(!preg_match('/[0-9]/', $pass)){
    $session->set('error_message', 'La contraseña necesita al menos un numero.');

    header('Location: ../registrarse.php');
    exit(); 
}
// Validación de espacios en blanco en la contraseña.
else if(strpos($pass, " ") !== false){
    $session->set('error_message', 'La contraseña no debe contener espacios en blanco.');

    header('Location: ../registrarse.php');
    exit(); 
}
// Si todas las validaciones pasan...
else {
    // 5. Verificar si el correo ya está registrado en la base de datos.
    // ***MEJORA DE SEGURIDAD Y PREVENCIÓN DE INYECCIÓN SQL:***
    // Se utiliza una sentencia preparada (prepared statement) para evitar inyección SQL.
    // Esto es muy importante cuando insertas datos recibidos del usuario.
    $usuario = $controlador->obtener($email);
    
    // Si se encontró un correo, significa que ya está registrado.
    if($usuario){ // Cambiado de $email_bd == $email a simplemente verificar $user_email
        $session->set('error_message', 'Este correo ya esta registrado.');

        header('Location: ../registrarse.php');
    exit(); 
    }
    // Si el correo no está registrado, procede con la inserción.
    else {
        // 6. Insertar los datos del nuevo administrador en la base de datos.
        // ***CORRECCIÓN CRÍTICA:*** Nombres de columnas actualizados según tu BDD:
        // 'nombres', 'apellidos', 'correo', 'contraseña'.
        // 'null' para 'id_admin' (AUTO_INCREMENT), 'reset_token', 'reset_token_expires_at'.
        // ***MEJORA DE SEGURIDAD Y PREVENCIÓN DE INYECCIÓN SQL:***
        // Se utiliza otra sentencia preparada para la inserción.
        $usuario = $controlador->insertar($nom, $apell, $email, $pass_hash, $token, $date);

        if ($usuario) {
            $session->set('exito', 'Registro exitoso.');

            header('Location: login.php');
            exit(); 
        } else {
            // Manejo de error si la inserción falla (por ejemplo, problema con la base de datos)
            $session->set('error_message', 'Error con la base de datos.');

            header('Location: ../registrarse.php');
        }
    }
}
// Cierre de la conexión a la base de datos (Buena práctica).
mysqli_close($enlace);

?>