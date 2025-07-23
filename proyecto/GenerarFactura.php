<?php
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener el correo del responsable de la sesión (si existe)
$correoResponsable = $_SESSION['correo'] ?? 'No especificado';

// Procesar formulario POST si se confirma la venta
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['accion']) && $_POST['accion'] === 'confirmar_venta') {
    $metodo = mysqli_real_escape_string($conexion, $_POST['metodo_pago_enviar']);
    $totalFactura = floatval($_POST['total_factura']);
    $fecha = date("Y-m-d H:i:s");

    // Insertar en la tabla factura (ajusta los nombres de columnas si son diferentes)
    $insert_factura = "INSERT INTO factura (fecha, metodo_pago, total, responsable)
                       VALUES ('$fecha', '$metodo', $totalFactura, '$correoResponsable')";

    if (mysqli_query($conexion, $insert_factura)) {
        echo "<script>alert('✅ Venta confirmada y guardada exitosamente.');</script>";
        unset($_SESSION['ventas_recientes']); // Limpia las ventas registradas anteriores
    } else {
        echo "<script>alert('❌ Error al guardar la factura: " . mysqli_error($conexion) . "');</script>";
    }
}
?>

<!-- Mostrar el responsable actual -->
<div style="margin-top: 15px; font-weight: bold;">
    Responsable: <span style="color: #333;"><?php echo htmlspecialchars($correoResponsable); ?></span>
</div>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .factura {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 25px;
            border: 1px solid #000;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        h1, h3, h2 {
            text-align: center;
            margin-bottom: 0;
        }
        .info, .resumen-impuestos, .totales {
            margin-top: 20px;
        }
        .info p, .totales div {
            margin: 4px 0;
        }
        .info-emisor, .resolucion, .info-cliente {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .btn-confirmar {
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            display: block;
            margin-left: auto;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>
<body>
<div class="factura">
    <h1>RESTAURANTE KENNY</h1>
    <h3>Factura de Venta</h3>

    <div class="info-emisor">
        <strong>Razón Social:</strong> Restaurante KENNYS.A.S<br>
        <strong>NIT:</strong> 900123456-7<br>
        <strong>Dirección:</strong> Calle 123 #45-67, Bogotá D.C.<br>
        <strong>Teléfono:</strong> (1) 1234567<br>
        <strong>Responsabilidad Fiscal:</strong> Régimen Común – Gran Contribuyente
    </div>

    <div class="resolucion">
        <div><strong>Factura No.:</strong> POS-0000123</div>
        <div><strong>Resolución DIAN No.:</strong> 18764000123789</div>
        <div><strong>Vigencia:</strong> del 01/01/2025 al 31/12/2025</div>
        <div><strong>Rango autorizado:</strong> POS-0000001 al POS-0999999</div>
    </div>

    <div class="info-cliente">
        <strong>Cliente:</strong> undefined<br>
        <strong>Documento:</strong> CC 1234567890<br>
        <strong>Teléfono:</strong> 3101234567<br>
    </div>

    <?php
    // Por defecto efectivo, pero puede cambiarse si se envía el formulario
    $metodo_pago = isset($_POST['metodo_pago']) ? $_POST['metodo_pago'] : 'Efectivo';
    ?>

    <!-- FORMULARIO DE MÉTODO DE PAGO -->
    <form method="POST">
        <label for="metodo_pago"><strong>Método de Pago:</strong></label>
        <select id="metodo_pago" name="metodo_pago" onchange="this.form.submit()">
            <option value="Efectivo" <?php if ($metodo_pago == 'Efectivo') echo 'selected'; ?>>Efectivo</option>
            <option value="Tarjeta" <?php if ($metodo_pago == 'Tarjeta') echo 'selected'; ?>>Tarjeta</option>
        </select>
    </form>


    <?php
    if (!isset($_SESSION['ventas_recientes']) || empty($_SESSION['ventas_recientes'])) {
        echo "<p>No se encontró ninguna venta registrada recientemente.</p>";
        exit;
    }

    $ids = implode(',', array_map('intval', $_SESSION['ventas_recientes']));

    $sql = "SELECT v.id_venta, p.id_pla, p.nombre AS descripcion, p.precio, v.cantidad, v.precio_total
            FROM venta v
            JOIN platillo p ON v.id_pla = p.id_pla
            WHERE v.id_venta IN ($ids)";

    $result = mysqli_query($conexion, $sql);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($result) > 0) {
        $firstRow = mysqli_fetch_assoc($result);
        $nFactura = $firstRow['id_venta'];
        mysqli_data_seek($result, 0);

        echo "<div class='info'>
                <p><strong>N° Factura:</strong> $nFactura</p>
                <p><strong>Método de Pago:</strong> " . htmlspecialchars($metodo_pago) . "</p>
            </div>";


        echo "<table>
                <thead>
                    <tr>
                        <th>ID Platillo</th>
                        <th>Descripción</th>
                        <th>Precio Unidad</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>";

        $total = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id_pla']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>\${$row['precio']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>\${$row['precio_total']}</td>
                  </tr>";
            $total += $row['precio_total'];
        }

        echo "</tbody></table>";

        echo "<div class='total'>
                <strong>Total Factura: \$" . number_format($total, 2) . "</strong>
              </div>";
    } else {
        echo "<p>No se encontraron ventas para mostrar.</p>";
    }
    ?>

    <h2>Resumen de Impuestos</h2>
<div class="totales">
<?php
if (!empty($ids)) {
    $sql_total = "
        SELECT SUM(precio_total) AS subtotal_general
        FROM venta
        WHERE id_venta IN ($ids)
    ";

    $result_total = mysqli_query($conexion, $sql_total);
    $mostrar = mysqli_fetch_assoc($result_total);

    $subtotal = $mostrar['subtotal_general'] ?? 0;
    $iva = $subtotal * 0.19;
    $descuento = 2000;
    $total_a_pagar = $subtotal + $iva - $descuento;
?>
    <div><span>Subtotal:</span> $<?php echo number_format($subtotal, 2); ?></div>
    <div><span>IVA (19%):</span> $<?php echo number_format($iva, 2); ?></div>
    <div><span>Descuento:</span> -$<?php echo number_format($descuento, 2); ?></div>
    <div><strong>Total a Pagar:</strong> $<?php echo number_format($total_a_pagar, 2); ?></strong></div>
<?php
} else {
    echo "<div>No se encontraron ventas para calcular impuestos.</div>";
}
?>

</div>

<div class="responsable">
    <strong>Responsable Venta:</strong><br>
    <?php
    echo htmlspecialchars($_SESSION['correo'] ?? 'Correo no disponible');
    ?>
</div>






<form method="POST">
    <input type="hidden" name="accion" value="confirmar_venta">
    <input type="hidden" name="total_factura" value="<?php echo $total_a_pagar; ?>">
    <input type="hidden" name="metodo_pago_enviar" value="<?php echo $metodo_pago; ?>">
    <button type="submit" class="btn-confirmar">Confirmar Venta</button>
</form>


<div class="footer">
    Esta factura se expide como título valor.<br>
    Para efectos fiscales se considera equivalente a factura según Art. 616-1 del E.T.
</div>



</div>

<!-- Tu contenido HTML aquí -->

<?php
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] === 'ok') {
        echo "<script>alert('Factura registrada correctamente.');</script>";
    } elseif ($_GET['mensaje'] === 'error') {
        echo "<script>alert('Error al registrar la factura.');</script>";
    }
}
?>

</body>
</html>


</body>
</html>
