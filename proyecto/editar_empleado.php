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
?>

    <div class="container">
        <h2>Editar empleado</h2>
        <form action="./php/editarEmp.php" method="POST">
            <div class="form-group">
                    <input type="hidden" name="id_empleado" value="<?php echo htmlspecialchars($id_empleado); ?>">
                    
                    <label for="fname"></label>
                    <input type="text" id="nombre" name="fname" placeholder="Nombre">
                    <label for="lname"></label>
                    <input type="text" id="apelli" name="lname" placeholder="Apellido">
            </div>
            <div class="form-group">
                    <label for="fname"></label>
                    <input type="password" id="contra" name="password" placeholder="Contraseña">
                    <label for="lname"></label>
                    <input type="text" id="telefono" name="tele" placeholder="Telefono">
            </div>
            <div class="form-group">
                    <label for="lname"></label>
                    <input type="email" id="correo" name="email" placeholder="Correo">
            </div>

            <div class="form-group">
                    <label for="lname"></label>
                    <input type="number" id="id" name="documento" placeholder="Documento de identidad">
                    <select name="select" id="rol">
                        <option value="">Rol</option>
                        <option value="Mesero">Mesero</option>
                        <option value="Cocinero">Cocinero</option>
                        <option value="Limpieza">Limpieza</option>
                    </select>
            </div>

            <button type="submit" class="btn">Editar empleado</button>
        </form>
    </div>

</body>
</html>