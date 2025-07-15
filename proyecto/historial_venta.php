<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="venta_empleado.css">
</head>
<body>
    <!-- Barra superior -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="navbar-brand">VENTAS</span>
            <ul class="navbar-menu">
                <li><a href="venta_empleado.php">Vender</a></li>
                <li><a href="historial_venta.php" class="active">Ventas</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="titulo">Historial de Ventas</h1>
        <table class="tabla-venta" id="tablaVentas">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Platillos</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de ventas, reemplazar por datos reales -->
                <tr>
                    <td>1</td>
                    <td>2024-06-01 13:45</td>
                    <td>
                        <ul style="text-align:left; margin:0; padding-left:1em;">
                            <li>Taco x2 ($40.00)</li>
                            <li>Enchilada x1 ($25.00)</li>
                        </ul>
                    </td>
                    <td>$65.00</td>
                    <td>
                        <button class="btn-eliminar" title="Eliminar"><span class="icon-trash">🗑️</span></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2024-06-02 09:30</td>
                    <td>
                        <ul style="text-align:left; margin:0; padding-left:1em;">
                            <li>Quesadilla x3 ($60.00)</li>
                        </ul>
                    </td>
                    <td>$60.00</td>
                    <td>
                        <button class="btn-eliminar" title="Eliminar"><span class="icon-trash">🗑️</span></button>
                    </td>
                </tr>
                <!-- ...más ventas... -->
            </tbody>
        </table>
    </div>
</body>
</html>
