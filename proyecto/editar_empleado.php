<?php
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
    <link rel="stylesheet" href="registrarProductos.css"> </head>
<body>
<?php
if (isset($_GET['id'])) {
    $id_empleado = mysqli_real_escape_string($conexion, $_GET['id']);
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
}

?>

    <div class="container">
        <h2>Editar empleado</h2>
        <form action="./php/editarEmp.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_empleado" value="<?php echo htmlspecialchars($id_empleado); ?>">
                    
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
                    if ($id_rol == 1){ 
                    ?>
                        <select name="select" id="rol">
                        <option value="Mesero">Mesero</option>
                        <option value="Cocinero">Cocinero</option>
                        <option value="Limpieza">Limpieza</option>
                        </select>
                    <?php
                    }
                    ?>
                                        <?php
                    if ($id_rol == 2){ 
                    ?>
                        <select name="select" id="rol">
                        <option value="Cocinero">Cocinero</option>
                        <option value="Limpieza">Limpieza</option>
                        <option value="Mesero">Mesero</option>
                        </select>
                    <?php
                    }
                    ?>
                    <?php
                    if ($id_rol == 3){ 
                    ?>
                        <select name="select" id="rol">
                        <option value="Limpieza">Limpieza</option>
                        <option value="Cocinero">Cocinero</option>
                        <option value="Mesero">Mesero</option>
                        </select>
                    <?php
                    }
                    ?>
            </div>

            <button type="submit" class="btn">Editar empleado</button>
        </form>
    </div>

</body>
</html>