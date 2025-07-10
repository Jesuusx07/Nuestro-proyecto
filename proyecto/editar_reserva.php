<?php

require_once './php/SessionManager.php';

$session = new SessionManager();
$conexion = mysqli_connect('localhost', 'root', '', 'proyecto_kenny');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor - Kenny's Restaurante</title>
    <link rel="stylesheet" href="css/editarEmpleado.css">
 </head>
<body>
<?php
if (isset($_GET['id'])) {
    $id_reserva = mysqli_real_escape_string($conexion, $_GET['id']);
}
if (isset($_GET['nombre'])) {
    $nombre = mysqli_real_escape_string($conexion, $_GET['nombre']);
}
if (isset($_GET['apellido'])) {
    $apellido = mysqli_real_escape_string($conexion, $_GET['apellido']);
}
if (isset($_GET['fecha'])) {
    $fecha = mysqli_real_escape_string($conexion, $_GET['fecha']);
}
if (isset($_GET['estado'])) {
    $estado = mysqli_real_escape_string($conexion, $_GET['estado']);
}

?>

    <div class="container">
        <h2>Editar Reserva</h2>
        <form action="./php/editarReserva.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_reserva); ?>">
            </div>
            <div class="form-group">
                    <label for="lname">Fecha</label>
                    <input type="text" id="telefono" name="fecha" value="<?php echo trim($fecha)?>">
            </div>

            <label for="estado">Estado</label>
                <?php
                if ($estado == "Activo "){ 
                ?>
                    <select name="estado" id="estado">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                    </select>
                <?php
                }
                ?>
                <?php
                if ($estado == 'Inactivo '){ 
                ?>
                    <select name="estado" id="estado">
                    <option value="Inactivo">Inactivo</option>
                    <option value="Activo">Activo</option>
                    </select>
                <?php
                }
                ?>
                    <style>
                      .p-error{
                        color: #A02334;
                        text-align: center;
                        font-size: 20px;    
                      }
                    </style>
                    <?php
                    // Aquí es donde verificas y muestras el mensaje
                        if ($session->has('error_message')) {
                          echo '<div class="error-message">';
                          echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
                          echo '</div>';
                          $session->remove('error_message'); // Borra el mensaje después de mostrarlo
                      }
                    ?>
            <button type="submit" class="btn">Editar reserva</button>
        </form>
    </div>

</body>
</html>