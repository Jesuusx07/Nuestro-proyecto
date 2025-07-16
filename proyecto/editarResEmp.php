<?php

require_once './php/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: login.php");
    }

?>
<?php

require_once './php/SessionManager.php';
require_once './php/sql.php'; // Asumiendo que este archivo contiene la clase Database con conexión PDO

$session = new SessionManager();

// Conectar a la base de datos usando la clase Database
try {
    $db = (new Database())->conectar();
} catch (PDOException $e) {
    // Manejo de errores si la conexión falla
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Inicializar variables para los campos del formulario
$id_reserva = '';
$nombre_cliente = '';
$fecha_reserva = '';
$estado_reserva = '';

// Obtener datos de la URL (parámetros GET)
// Es crucial que estos parámetros se pasen correctamente desde la página que enlaza a esta.
if (isset($_GET['id_reserva'])) {
    $id_reserva = htmlspecialchars($_GET['id_reserva']);
}
if (isset($_GET['nombre_cliente'])) {
    $nombre_cliente = htmlspecialchars($_GET['nombre_cliente']);
}
if (isset($_GET['fecha_reserva'])) {
    $fecha_reserva = htmlspecialchars($_GET['fecha_reserva']);
}
if (isset($_GET['estado_reserva'])) {
    $estado_reserva = htmlspecialchars($_GET['estado_reserva']);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva - Kenny's Restaurante</title>
    <!-- Revisa si este CSS es adecuado para tu diseño de reservas o si necesitas uno nuevo -->
    <link rel="stylesheet" href="css/editarEmpleado.css">
</head>
<body>

    <div class="container">
        <h2>Editar Reserva</h2>
        <!-- El formulario enviará los datos al script PHP que procesará la actualización de la reserva -->
        <form action="./php/editarReserva.php" method="POST">
            <div class="form-group">
                <!-- Campo oculto para enviar el ID de la reserva a editar -->
                <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">

                <label for="nombre_cliente">Nombre del Cliente</label>
                <!-- trim() para eliminar espacios en blanco al inicio/final del nombre -->
                <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo trim($nombre_cliente); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_reserva">Fecha de Reserva</label>
                <!-- Tipo "date" para un selector de fecha amigable -->
                <input type="date" id="fecha_reserva" name="fecha_reserva" value="<?php echo $fecha_reserva; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado_reserva">Estado de la Reserva</label>
                <!-- Menú desplegable para el estado de la reserva -->
                <select id="estado_reserva" name="estado_reserva" required>
                    <option value="Pendiente" <?php echo ($estado_reserva == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Confirmada" <?php echo ($estado_reserva == 'Confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                    <option value="Cancelada" <?php echo ($estado_reserva == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                </select>
            </div>

            <!-- Estilos para mensajes de error, si los hay -->
            <style>
                .p-error{
                    color: #A02334;
                    text-align: center;
                    font-size: 20px;
                }
            </style>
            <?php
            // Aquí es donde verificas y muestras el mensaje de error de la sesión
            if ($session->has('error_message')) {
                echo '<div class="error-message">';
                echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
                echo '</div>';
                $session->remove('error_message'); // Borra el mensaje después de mostrarlo
            }
            ?>
            <button type="submit" class="btn">Editar Reserva</button>
        </form>
    </div>

</body>
</html>