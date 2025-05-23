<?php
// 1. Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "kennys");

// 2. Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 3. Obtener datos del formulario y limpiar
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$correo = trim($_POST['correo']);
$pass = trim($_POST['pass']);

// 4. Validar que el correo no esté registrado
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "El correo ya está registrado. <a href='../login.html'>Inicia sesión</a>";
    $stmt->close();
    $conexion->close();
    exit;
}
$stmt->close();

// 5. Encriptar la contraseña
$hash = password_hash($pass, PASSWORD_DEFAULT);

// 6. Insertar nuevo usuario
$stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, correo, pass) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $correo, $hash);

if ($stmt->execute()) {
    echo "✅ Registro exitoso. <a href='../login.html'>Inicia sesión aquí</a>";
} else {
    echo "❌ Error al registrar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
