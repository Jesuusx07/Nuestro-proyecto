<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pedido - Kenny's Restaurante</title>
   <link rel="stylesheet" href="./css/registrarPedidos.css"> </head>
<body>

    <div class="container">
        <h2>Registro de Nuevo Pedido</h2>
        <form action="procesar_pedido.php" method="POST">

            <div class="form-group">
                <label for="id_empleado">Empleado:</label>
                <select id="id_empleado" name="id_empleado" required>
                    <option value="">Selecciona un empleado</option>
                    <option value="101">Juan Pérez (ID: 101)</option>
                    <option value="102">María García (ID: 102)</option>
                    <option value="103">Carlos López (ID: 103)</option>
                    <option value="104">Ana Martínez (ID: 104)</option>
                    </select>
            </div>

            <div class="form-group">
                <label for="fecha_pedido">Fecha del Pedido:</label>
                <input type="date" id="fecha_pedido" name="fecha_pedido" value="2025-06-13" required>
            </div>

            <div class="form-group">
                <label for="fecha_entrega_estimada">Fecha de Entrega Estimada:</label>
                <input type="date" id="fecha_entrega_estimada" name="fecha_entrega_estimada">
            </div>

            <div class="form-group">
                <label for="direccion_envio">Dirección de Envío:</label>
                <input type="text" id="direccion_envio" name="direccion_envio" placeholder="Ej: Calle 10 # 20-30, Bogotá" required>
            </div>

            <div class="form-group">
                <label for="estado_pedido">Estado del Pedido:</label>
                <select id="estado_pedido" name="estado_pedido" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="En preparación">En preparación</option>
                    <option value="En camino">En camino</option>
                    <option value="Completado">Completado</option>
                    <option value="Cancelado">Cancelado</option>
                    <option value="Pendiente de pago">Pendiente de pago</option>
                </select>
            </div>

            <div class="form-group">
                <label for="total_pedido">Total del Pedido ($):</label>
                <input type="number" id="total_pedido" name="total_pedido" step="0.01" min="0" required>
            </div>

            <button type="submit" class="btn">Registrar Pedido</button>
        </form>
    </div>

</body>
</html>