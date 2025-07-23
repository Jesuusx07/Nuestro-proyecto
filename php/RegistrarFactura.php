<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['accion']) && $_POST['accion'] === 'confirmar_venta') {
    $metodo = mysqli_real_escape_string($conexion, $_POST['metodo_pago_enviar']);
    $totalFactura = floatval($_POST['total_factura']);
    $fecha = date("Y-m-d H:i:s");

    $insert_factura = "INSERT INTO factura (fecha, metodo_pago, total) VALUES ('$fecha', '$metodo', $totalFactura)";

    if (mysqli_query($conexion, $insert_factura)) {
        // Redirigir de nuevo a GenerarFactura con éxito
        header("Location: GenerarFactura.php?mensaje=ok");
        exit();
    } else {
        header("Location: GenerarFactura.php?mensaje=error");
        exit();
    }
}
?>
