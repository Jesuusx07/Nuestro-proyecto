<?php  
require_once 'Venta.php';
require_once 'VentaController.php';
require_once '../Config/SessionManager.php';
require_once '../Config/sql.php';

session_start();
$_SESSION['ventas_recientes'] = []; // Limpiamos anteriores

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['id_pla'], $_POST['cantidad'], $_POST['total']) &&
        is_array($_POST['id_pla']) && is_array($_POST['cantidad']) && is_array($_POST['total'])
    ) {
        $controller = new VentaController($enlace);

        $id_platillos = $_POST['id_pla'];
        $cantidades = $_POST['cantidad'];
        $totales = $_POST['total'];
        $fecha_actual = date('Y-m-d');

        $ventasInsertadas = [];

        for ($i = 0; $i < count($id_platillos); $i++) {
            $id_pla = trim($id_platillos[$i]);
            $cantidad = trim($cantidades[$i]);
            $precio_total = trim($totales[$i]);

            // Validaciones
            if ($id_pla === '' || $cantidad === '' || $precio_total === '') {
                echo "<script>alert('❌ Datos vacíos en la fila " . ($i + 1) . "'); window.history.back();</script>";
                exit();
            }

            if (!is_numeric($cantidad) || !is_numeric($precio_total) || $cantidad <= 0 || $precio_total <= 0) {
                echo "<script>alert('❌ Datos inválidos en cantidad o total en la fila " . ($i + 1) . "'); window.history.back();</script>";
                exit();
            }

            // Crear objeto venta y asignar valores
            $venta = new Venta($enlace);
            $venta->id_pla = $id_pla;
            $venta->cantidad = $cantidad;
            $venta->precio_total = $precio_total;
            $venta->fecha = $fecha_actual;

            $idInsertado = $controller->registrar($venta);

            if ($idInsertado) {
                $ventasInsertadas[] = $idInsertado;
            }
        }

        $_SESSION['ventas_recientes'] = $ventasInsertadas;
        header("Location: GenerarFactura.php");
        exit();
    }
}

// --- Confirmar venta: insertar factura ---
$conexion = mysqli_connect("localhost", "u112415144_kenny", "", "proyecto_kenny");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['accion']) && $_POST['accion'] === 'confirmar_venta') {
    $metodo = mysqli_real_escape_string($conexion, $_POST['metodo_pago_enviar']);
    $totalFactura = floatval($_POST['total_factura']);

    // Última venta registrada
    $nFactura = intval($_SESSION['ventas_recientes'][0] ?? 0);

    // Correo del responsable desde la sesión
    $responsable = mysqli_real_escape_string($conexion, $_SESSION['correo'] ?? 'No especificado');

    // Insertar factura (sin fecha)
    $insert_factura = "INSERT INTO factura (id_venta, total_factura_ConImpuestos, responsable, metodo_pago)
                       VALUES ($nFactura, $totalFactura, '$responsable', '$metodo')";

    if (mysqli_query($conexion, $insert_factura)) {
        echo "<script>alert('Venta confirmada y guardada exitosamente.');</script>";
        unset($_SESSION['ventas_recientes']);
    } else {
        echo "<script>alert('Error al guardar la factura: " . mysqli_error($conexion) . "');</script>";
    }
}
?>
