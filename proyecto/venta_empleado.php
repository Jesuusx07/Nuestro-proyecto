<?php
require_once './php/SessionManager.php';

$session = new SessionManager();
if (!$session->isLoggedIn()) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vender</title>
    <link rel="stylesheet" href="./css/venta_empleado.css"">
</head>
<body>
    <!-- Barra superior -->
    <nav class="navbar">
           <div class="perfil">
    
   
            </div>
        <div class="navbar-container">
            <span class="navbar-brand">VENDER</span>
            <ul class="navbar-menu">
                <li><a href="venta_empleado.php" class="active">Vender</a></li>
                <li><a href="historial_venta.php">Ventas</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="titulo">PROCESO DE VENTA</h1>
        <form id="ventaForm" method="post" action="registrar_venta.php">
            <div class="acciones-superiores">
                <button type="button" class="btn-nuevo" onclick="agregarFila()">Nuevo <span class="icon-mas">+</span></button>
            </div>

            <table class="tabla-venta" id="platillosTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Platillo</th>
                        <th>Cantidad</th>
                        <th>Precio por unidad</th>
                        <th>Precio total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="num-fila">1</td>
                        <td><input type="text" name="platillo[]" required></td>
                        <td><input type="number" name="cantidad[]" min="1" value="1" required onchange="calcularFila(this)"></td>
                        <td><input type="number" name="precio_unidad[]" step="0.01" value="0.00" required onchange="calcularFila(this)"></td>
                        <td><input type="text" name="precio_total[]" value="0.00" readonly></td>
                        <td><button type="button" class="btn-eliminar" onclick="eliminarFila(this)">🗑️</button></td>
                    </tr>
                </tbody>
            </table>

            <div class="total-final">
                <span>Precio Final: $<span id="precioFinal">0.00</span></span>
            </div>

            <div class="acciones-inferiores">
                <button type="submit" class="sub-btn">Generar Factura</button>
            </div>
        </form>
    </div>

    <script>
            // ----- Tema claro / oscuro -----
    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme');
    });
        function calcularFila(element) {
            const row = element.closest('tr');
            const cantidad = parseFloat(row.querySelector('input[name="cantidad[]"]').value) || 0;
            const precioUnidad = parseFloat(row.querySelector('input[name="precio_unidad[]"]').value) || 0;
            const precioTotal = cantidad * precioUnidad;
            row.querySelector('input[name="precio_total[]"]').value = precioTotal.toFixed(2);
            calcularPrecioFinal();
        }

        function calcularPrecioFinal() {
            let suma = 0;
            document.querySelectorAll('input[name="precio_total[]"]').forEach(input => {
                suma += parseFloat(input.value) || 0;
            });
            document.getElementById('precioFinal').textContent = suma.toFixed(2);
        }

        function agregarFila() {
            const tabla = document.querySelector('#platillosTable tbody');
            const nuevaFila = tabla.rows[0].cloneNode(true);
            nuevaFila.querySelectorAll('input').forEach(input => {
                if (input.name === "platillo[]") input.value = "";
                if (input.name === "cantidad[]") input.value = 1;
                if (input.name === "precio_unidad[]") input.value = "0.00";
                if (input.name === "precio_total[]") input.value = "0.00";
            });
            tabla.appendChild(nuevaFila);
            actualizarNumerosFila();
        }

        function eliminarFila(btn) {
            const tabla = document.querySelector('#platillosTable tbody');
            if (tabla.rows.length > 1) {
                btn.closest('tr').remove();
                calcularPrecioFinal();
                actualizarNumerosFila();
            }
        }

        function actualizarNumerosFila() {
            const filas = document.querySelectorAll('#platillosTable tbody tr');
            filas.forEach((tr, idx) => {
                tr.querySelector('.num-fila').textContent = idx + 1;
            });
        }

        // Inicialización
        document.querySelectorAll('input[name="cantidad[]"], input[name="precio_unidad[]"]').forEach(input => {
            input.addEventListener('change', function () {
                calcularFila(this);
            });
        });

        calcularPrecioFinal();
    </script>
</body>
</html>
