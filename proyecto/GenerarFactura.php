<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Factura DIAN</title>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
  <style>
    :root {
      --color-fondo: #f8f9fa;
      --color-texto: #000000;
      --color-borde: #dee2e6;
      --color-primario: #000000;
      --color-secundario: #6c757d;
      --color-acento: #ffad60;
    }

    body {
      font-family: 'Exo 2', sans-serif;
      background: var(--color-fondo);
      color: var(--color-texto);
      padding: 2rem;
    }

    .factura {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1, h2 {
      text-align: center;
      margin-bottom: 1rem;
      color: var(--color-primario);
    }

    .info-emisor, .info-cliente, .resolucion, .totales {
      margin-bottom: 1rem;
    }

    .info-emisor div,
    .info-cliente div,
    .resolucion div {
      margin: 2px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      border: 1px solid var(--color-borde);
      padding: 0.6rem;
      text-align: left;
    }

    th {
      background: var(--color-primario);
      color: white;
    }

    .totales {
      margin-top: 2rem;
      font-size: 1.1rem;
    }

    .totales div {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
    }

    .footer {
      font-size: 0.85rem;
      color: var(--color-secundario);
      text-align: center;
      margin-top: 2rem;
    }

    .btn-confirmar {
      margin-top: 2rem;
      padding: 0.8rem 2rem;
      font-size: 1rem;
      background-color: var(--color-acento);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .btn-confirmar:hover {
      background-color: #a02334;
    }
  </style>
</head>
<body>
  <div class="factura">
    <h1>FACTURA DE VENTA</h1>

    <div class="info-emisor">
      <strong>Razón Social:</strong> Restaurante KENNYS.A.S<br>
      <strong>NIT:</strong> 900123456-7<br>
      <strong>Dirección:</strong> Calle 123 #45-67, Bogotá D.C.<br>
      <strong>Teléfono:</strong> (1) 1234567<br>
      <strong>Responsabilidad Fiscal:</strong> Régimen Común – Gran Contribuyente
    </div>

    <div class="resolucion">
      <div><strong>Factura No.:</strong> 
        <?php
          $conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
          $query = mysqli_query($conexion, "SELECT MAX(id_factura) AS ultima FROM factura");
          $row = mysqli_fetch_assoc($query);
          $idFactura = $row['ultima'];
          echo "POS-" . str_pad($idFactura, 7, '0', STR_PAD_LEFT);
        ?>
      </div>
      <div><strong>Resolución DIAN No.:</strong> 18764000123789</div>
      <div><strong>Vigencia:</strong> del 01/01/2025 al 31/12/2025</div>
      <div><strong>Rango autorizado:</strong> POS-0000001 al POS-0999999</div>
    </div>

    <div class="info-cliente">
      <strong>Cliente:</strong> No registrado<br>
      <strong>Documento:</strong> CC 1234567890<br>
      <strong>Teléfono:</strong> 3101234567<br>
    </div>

    <div><strong>Fecha:</strong> <?php echo date("d/m/Y"); ?></div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>ID_Platillo</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Valor Unitario</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT f.id_factura, f.metodo_pago, f.total_factura_ConImpuestos,
                       v.id_venta, v.cantidad, v.precio_total,
                       p.id_pla, p.nombre, p.precio
                FROM factura f
                JOIN venta v ON f.id_factura = v.id_factura
                JOIN platillo p ON v.id_pla = p.id_pla
                WHERE f.id_factura = $idFactura";

        $result = mysqli_query($conexion, $sql);
        $metodoPago = "Desconocido";
        $totalFactura = 0;

        while ($row = mysqli_fetch_assoc($result)) {
          $metodoPago = $row['metodo_pago'];
          $totalFactura = $row['total_factura_ConImpuestos'];

          echo "<tr>
                  <td>{$row['id_venta']}</td>
                  <td>{$row['id_pla']}</td>
                  <td>{$row['nombre']}</td>
                  <td>{$row['cantidad']}</td>
                  <td>$" . number_format($row['precio'], 2) . "</td>
                  <td>$" . number_format($row['precio_total'], 2) . "</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>

    <h2>Resumen de Impuestos</h2>
    <div class="totales">
      <div><span>Forma de Pago:</span> <?php echo $metodoPago; ?></div>
      <div><span>Fecha de Pago:</span> <?php echo date("d/m/Y"); ?></div>
      <div><span>Subtotal:</span> $<?php echo number_format($totalFactura / 1.19, 2); ?></div>
      <div><span>IVA (19%):</span> $<?php echo number_format($totalFactura - ($totalFactura / 1.19), 2); ?></div>
      <div><span>Descuento:</span> -$0.00</div>
      <div><strong>Total a Pagar:</strong> $<?php echo number_format($totalFactura, 2); ?></div>
    </div>

    <button class="btn-confirmar">Confirmar Venta</button>
  </div>

  <div class="footer">
    Esta factura se expide como título valor.<br>
    Para efectos fiscales se considera equivalente a factura según Art. 616-1 del E.T.
  </div>
</body>
</html>
