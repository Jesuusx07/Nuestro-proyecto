<?php

require_once '../Config/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: login.php");
    }

?>
<?php

require_once '../Config/SessionManager.php';

$session = new SessionManager();
<<<<<<< HEAD
$conexion = mysqli_connect("kennys.online", "u112415144_kenny", "Kennys12345", "u112415144_proyecto_kenny");
=======
$conexion = mysqli_connect('151.106.96.29', 'u112415144_kenny', '', 'u112415144_proyecto_kenny');
>>>>>>> 67da95da794188e84d41f98f008e259865f2bd1e

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
if (isset($_GET['fecha'])) {
    $fecha = mysqli_real_escape_string($conexion, $_GET['fecha']);
}
if (isset($_GET['estado'])) {
    $estado = mysqli_real_escape_string($conexion, $_GET['estado']);
}

$estado = trim($estado)

?>

    <div class="container">
        <h2>Editar Reserva</h2>
        <form action="../Rutas/editarReserva.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_reserva); ?>">
            </div>
            <div class="form-group">
                    <label for="lname">Fecha</label>
                    <input type="datetime-local" id="telefono" name="fecha" value="<?php echo trim($fecha)?>">
            </div>

            <label for="estado">Estado</label>
                <?php
                if ($estado == "Activo"){ 
                ?>
                    <select name="estado" id="estado">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                    </select>
                <?php
                }
                ?>
                <?php
                if ($estado == 'Inactivo'){ 
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