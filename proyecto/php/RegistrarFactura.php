<?php
require_once 'FacturaController.php';
require_once 'PlatilloController.php';
require_once 'VentaController.php';
require_once 'SessionManager.php';
require_once 'sql.php';

            $venta = new Venta ($enlace);
            $venta->id_pla = $id_pla;
            $venta->cantidad = $cantidad;
            $venta->precio_total = $precio_total;


?>