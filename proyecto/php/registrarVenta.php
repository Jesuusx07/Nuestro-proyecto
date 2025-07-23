<?php 
require_once 'Venta.php';
require_once 'VentaController.php';
require_once 'SessionManager.php';
require_once 'sql.php';

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

        $ventasInsertadas = []; // 🆕 Guardar IDs

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

            $venta = new Venta($enlace);
            $venta->id_pla = $id_pla;
            $venta->cantidad = $cantidad;
            $venta->precio_total = $precio_total;
            $venta->fecha = $fecha_actual;

            $id_venta = $venta->insertar(); // 🆕 obtener ID insertado
            if (!$id_venta) {
                echo "<script>alert('❌ Fallo al registrar la venta en la fila " . ($i + 1) . "'); window.history.back();</script>";
                exit();
            }

            $ventasInsertadas[] = $id_venta; // 🆕 agregar ID al array
        }

        // 🆕 Redirigir pasando los IDs de venta como parámetro
        $ids = implode(',', $ventasInsertadas);
        echo "<script>
            alert('✅ Venta registrada correctamente.');
            window.location.href = '../GenerarFactura.php?ventas=$ids';
        </script>";
        exit();
    } else {
        echo "<script>alert('❌ Datos incompletos.'); window.history.back();</script>";
        exit();
    }
}
?>


