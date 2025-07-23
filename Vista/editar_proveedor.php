<?php

require_once './php/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: login.php");
    }

?>
<?php

require_once './php/SessionManager.php';

$session = new SessionManager();
$conexion = mysqli_connect('kennys.online', 'u112415144_kenny', '', 'u112415144_proyecto_kenny');

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
    $id_usuario = mysqli_real_escape_string($conexion, $_GET['id']);
}
if (isset($_GET['nom'])) {
    $nombre = mysqli_real_escape_string($conexion, $_GET['nom']);
}
if (isset($_GET['apell'])) {
    $apellido = mysqli_real_escape_string($conexion, $_GET['apell']);
}
if (isset($_GET['email'])) {
    $correo = mysqli_real_escape_string($conexion, $_GET['email']);
}
if (isset($_GET['tel'])) {
    $telefono = mysqli_real_escape_string($conexion, $_GET['tel']);
}
if (isset($_GET['docu'])) {
    $documento = mysqli_real_escape_string($conexion, $_GET['docu']);
}

?>

    <div class="container">
        <h2>Editar Proveedor</h2>
        <form action="./php/editarProveedor.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">

                    <label for="fname">Nombre</label>
                    <input type="text" id="nombre" name="fname" value="<?php echo trim($nombre)?>">
                    <label for="lname">Apellido</label>
                    <input type="text" id="apelli" name="lname" value="<?php echo trim($apellido)?>">
            </div>
            <div class="form-group">
                    <label for="lname">Telefono</label>
                    <input type="text" id="telefono" name="tele" value="<?php echo trim($telefono)?>">
            </div>
            <div class="form-group">
                    <label for="lname">Correo</label>
                    <input type="email" id="correo" name="email" value="<?php echo $correo?>">
            </div>

            <div class="form-group">
                    <label for="lname">Documento</label>
                    <input type="number" id="id" name="documento" value="<?php echo $documento?>">
                    
            </div>
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
            <button type="submit" class="btn">Editar empleado</button>
        </form>
    </div>

</body>
</html>