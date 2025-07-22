<?php
require_once 'Venta.php';
require_once 'VentaController.php';
require_once 'SessionManager.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['id_pla'], $_POST['cantidad'], $_POST['total']) &&
        is_array($_POST['id_pla']) && is_array($_POST['cantidad']) && is_array($_POST['total'])
    ) {
        require_once 'sql.php';
        $controller = new VentaController($enlace);

        $id_platillos = $_POST['id_pla'];
        $cantidades = $_POST['cantidad'];
        $totales = $_POST['total'];

        for ($i = 0; $i < count($id_platillos); $i++) {
            $id_pla = trim($id_platillos[$i]);
            $cantidad = trim($cantidades[$i]);
            $precio_total = trim($totales[$i]);

            if ($id_pla === '' || $cantidad === '' || $precio_total === '') {
                header("Location: ./venta_empleado.php?error=datos_vacios_fila_" . ($i + 1));
                exit();
            }

            if ($cantidad <= 0 || $precio_total <= 0) {
                header("Location: ./venta_empleado.php?error=cantidad_total_invalido_fila_" . ($i + 1));
                exit();
            }

            $venta = new Venta($enlace);
            $venta->id_pla = $id_pla;
            $venta->cantidad = $cantidad;
            $venta->precio_total = $precio_total;

            if (!$venta->insertar()) {
                header("Location: ./venta_empleado.php?error=fallo_registro_fila_" . ($i + 1));
                exit();
            }
        }

       
        // Si todo salió bien
        $session = new SessionManager();
        $session->set('success_message', 'Venta registrada correctamente.');
        header("Location: ./RegistrarFactura.php?mensaje=ok");
        exit();
    } else {
        header("Location: ../venta_empleado.php?error=datos_incompletos");
        exit();
    }
}

?>
