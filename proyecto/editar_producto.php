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
    <title>Registrar Producto - Kenny's Restaurante</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="registrarProductos.css"> </head>
<body>
<?php
if (isset($_GET['id'])) {
    $id_usuario = mysqli_real_escape_string($conexion, $_GET['id']);
}
if (isset($_GET['id_rol'])) {
    $id_rol = mysqli_real_escape_string($conexion, $_GET['id_rol']);
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
=======
    <link rel="stylesheet" href=".css/editarProducto.css"> </head>
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
>>>>>>> c3d6b9b8fd7ad0852f06d8b8101314b4008a411c
}

?>

    <div class="container">
        <h2>Editar empleado</h2>
<<<<<<< HEAD
        <form action="./php/editarEmp.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                    <input type="hidden" name="id_rol" value="<?php echo htmlspecialchars($id_rol); ?>">

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
                    <label for="rol">Rol</label>
                    <?php
                    if ($id_rol == "Mesero "){ 
                    ?>
                        <select name="select" id="rol">
                        <option value="Mesero">Mesero</option>
                        <option value="Cocinero">Cocinero</option>
                        <option value="Limpieza">Limpieza</option>
=======
        <form action="./php/editarProducto.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id_producto); ?>">
                    <input type="hidden" name="imagen1" value="<?php echo htmlspecialchars($imagen); ?>">

                    <label for="fname">nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo trim($nombre)?>">
                    <label for="lname">imagen</label>
                    <?php echo "<img src='" . "img_producto/" . htmlspecialchars($imagen) . " ' style='width:200px; height:auto;'>";?>
                    <input type="file" id="imagen" name="imagen" accept="image/*"?>">
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
>>>>>>> c3d6b9b8fd7ad0852f06d8b8101314b4008a411c
                        </select>
                    <?php
                    }
                    ?>
                    <?php
<<<<<<< HEAD
                    if ($id_rol == 'Cocinero '){ 
                    ?>
                        <select name="select" id="rol">
                        <option value="Cocinero">Cocinero</option>
                        <option value="Limpieza">Limpieza</option>
                        <option value="Mesero">Mesero</option>
=======
                    if ($categoria == 'Salsa '){ 
                    ?>
                        <select name="categoria" id="categoria">
                        <option value="Salsa">Salsa</option>
                        <option value="Fruta">Fruta</option>
                        <option value="Vegetal">Vegetal</option>
>>>>>>> c3d6b9b8fd7ad0852f06d8b8101314b4008a411c
                        </select>
                    <?php
                    }
                    ?>
                    <?php
<<<<<<< HEAD
                    if ($id_rol == 'Limpieza '){ 
                    ?>
                        <select name="select" id="rol">
                        <option value="Limpieza">Limpieza</option>
                        <option value="Cocinero">Cocinero</option>
                        <option value="Mesero">Mesero</option>
=======
                    if ($categoria == 'Fruta '){ 
                    ?>
                        <select name="categoria" id="categoria">
                        <option value="Fruta">Fruta</option>
                        <option value="Salsa">Salsa</option>
                        <option value="Vegetal">Vegetal</option>
>>>>>>> c3d6b9b8fd7ad0852f06d8b8101314b4008a411c
                        </select>
                    <?php
                    }
                    ?>
                    
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
<<<<<<< HEAD
            <button type="submit" class="btn">Editar empleado</button>
=======
            <button type="submit" class="btn">Editar producto</button>
>>>>>>> c3d6b9b8fd7ad0852f06d8b8101314b4008a411c
        </form>
    </div>

</body>
</html>