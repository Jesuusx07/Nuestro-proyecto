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
$conexion = mysqli_connect("kennys.online", "u112415144_kenny", "Kennys12345", "u112415144_proyecto_kenny");

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
if (isset($_GET['id'])) {
    $id_producto = mysqli_real_escape_string($conexion, $_GET['id']);
}
if (isset($_GET['categoria'])) {
    $categoria = mysqli_real_escape_string($conexion, $_GET['categoria']);
}
if (isset($_GET['nombre'])) {
    $nombre = mysqli_real_escape_string($conexion, $_GET['nombre']);
}
if (isset($_GET['imagen'])) {
    $imagen = mysqli_real_escape_string($conexion, $_GET['imagen']);
}
if (isset($_GET['precio_unitario'])) {
    $precio = mysqli_real_escape_string($conexion, $_GET['precio_unitario']);
}

?>

    <div class="container">
        <h2>Editar Producto</h2>
        <form action="./php/editarProducto.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id_producto); ?>">
                    <input type="hidden" name="imagen1" value="<?php echo htmlspecialchars($imagen); ?>">

                    <label for="fname">nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo trim($nombre)?>">
                    <label for="lname">imagen</label>
                    <?php echo "<img src='" . "img_producto/" . htmlspecialchars($imagen) . " ' style='width:200px; height:auto;'>";?>
                    <input type="file" id="imagen" name="imagen" accept="image/*"?>
            </div>
            <div class="form-group">
                    <label for="lname">precio</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" value="<?php echo($precio)?>">
            </div>

            <label for="categoria">categoria</label>
                <?php
                if ($categoria == "Vegetal "){ 
                ?>
                    <select name="categoria" id="categoria">
                    <option value="Vegetal">Vegetal</option>
                    <option value="Salsa">Salsa</option>
                    <option value="Fruta">Fruta</option>
                    </select>
                <?php
                }
                ?>
                <?php
                if ($categoria == 'Salsa '){ 
                ?>
                    <select name="categoria" id="categoria">
                    <option value="Salsa">Salsa</option>
                    <option value="Fruta">Fruta</option>
                    <option value="Vegetal">Vegetal</option>
                    </select>
                <?php
                }
                ?>
                <?php
                if ($categoria == 'Fruta '){ 
                ?>
                    <select name="categoria" id="categoria">
                    <option value="Fruta">Fruta</option>
                    <option value="Salsa">Salsa</option>
                    <option value="Vegetal">Vegetal</option>
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
            <button type="submit" class="btn">Editar</button>
        </form>
    </div>

</body>
</html>




