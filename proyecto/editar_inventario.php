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
    <title>Editar Producto - Kenny's Restaurante</title>
    <link rel="stylesheet" href="css/editarEmpleado.css">
</head>
<body>
<?php

if (isset($_GET['id_inventario'])) {
    $id_inventario = mysqli_real_escape_string($conexion, $_GET['id_inventario']);
}
if (isset($_GET['tipo'])) {
    $tipo = mysqli_real_escape_string($conexion, $_GET['tipo']);
}
if (isset($_GET['cantidad'])) {
    $cantidad = mysqli_real_escape_string($conexion, $_GET['cantidad']);
}

$cantidad = intval($cantidad); // Asegurarse de que sea un número entero

if ($cantidad < 0){
    $cantidad = -$cantidad;
}


?>

    <div class="container">
        <h2>Editar Producto</h2>
        <form action="./php/editarInventario.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_inventario" value="<?php echo htmlspecialchars($id_inventario); ?>">
            </div>
            <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>">
            </div>

            <label for="tipo">Tipo de movimiento</label>
                <?php
                if ($tipo == "entrada"){ 
                ?>
                    <select name="tipo" id="tipo">
                    <option value="entrada">entrada</option>
                    <option value="salida">salida</option>

                    </select>
                <?php
                }
                ?>
                <?php
                if ($tipo == 'salida'){ 
                ?>
                    <select name="tipo" id="tipo">
                    <option value="salida">salida</option>
                    <option value="entrada">entrada</option>
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
            <button type="submit" class="btn">Editar producto</button>
        </form>
    </div>

</body>
</html>