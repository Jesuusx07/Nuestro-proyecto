<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto - Kenny's Restaurante</title>
    <link rel="stylesheet" href="registrarProductos.css"> </head>
<body>

    <div class="container">
        <h2>Registro de Nuevo Producto</h2>
        <form action="procesar_registro.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecciona una categoría</option>
                    <option value="1">Pizzas</option>
                    <option value="2">Pastas</option>
                    <option value="3">Entradas</option>
                    <option value="4">Postres</option>
                    <option value="5">Bebidas</option>
                    <option value="6">Platos Fuertes</option>
                    </select>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad en Stock:</label>
                <input type="number" id="cantidad" name="cantidad" min="0" required>
            </div>

            <div class="form-group">
                <label for="precio">Precio Unitario:</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required>
            </div>

            <button type="submit" class="btn">Registrar Producto</button>
        </form>
    </div>

</body>
</html>