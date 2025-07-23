<?php
require_once './php/SessionManager.php';
$session = new SessionManager();

if (!$session->isLoggedIn()) {
    header("location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once './php/Venta.php';
require_once './php/VentaController.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['id_pla'], $_POST['cantidad'], $_POST['total'], $_POST['fecha']) &&
        is_array($_POST['id_pla']) &&
        is_array($_POST['cantidad']) &&
        is_array($_POST['total']) &&
        is_array($_POST['fecha'])
    ) {
        require_once 'php/sql.php';
        require_once 'php/VentaController.php';

        $controller = new VentaController($enlace);

        // Recorremos cada fila del formulario
        for ($i = 0; $i < count($_POST['id_pla']); $i++) {
            $id_pla = $_POST['id_pla'][$i];
            $cantidad = $_POST['cantidad'][$i];
            $precio_total = $_POST['total'][$i];
            $fecha = $_POST['fecha'][$i];

            // Validar que los campos sean numéricos y que la fecha exista
            if (is_numeric($id_pla) && is_numeric($cantidad) && is_numeric($precio_total) && !empty($fecha)) {
                $controller->insertar($id_pla, $cantidad, $precio_total, $fecha);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Administrativo</title>
  <link rel="stylesheet" href="./css/ventaEmpleado.css">
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
</head>

<body>

<header class="navbar">
     <a href="dashboard.php" class="logo-text">ADMINISTRADOR</a>
  <div class="navbar-right">
    <button id="themeToggle" title="Cambiar tema claro/oscuro">🌓</button>
    <div class="perfil">
      <button class="boton-perfil" id="perfilBtn">👤</button>
      <div class="menu-desplegable" id="perfilMenu">
        <a href="./php/logout.php"><span>🔓</span> Cerrar sesión</a>
      </div>
    </div>
  </div>
</header>

<main>
<div class="container">
  <div class="tabla-container">
    <h2 class="titulo">PROCESO VENTA</h2>

    <form action="./php/registrarVenta.php" method="POST">
      <table>
        <thead>
          <tr>
            <th>ID Venta</th>
            <th>Platillo</th>
            <th>Cantidad</th>
            <th>Precio Unidad</th>
            <th>Precio Total</th>
            <th>Fecha</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody id="ventaRows">
          <tr>
          <td>Auto</td>
          <td>
            <select name="id_pla[]" class="platillo" required>
              <option value="">Seleccione...</option>
              <?php
              $platillosQuery = mysqli_query($conexion, "SELECT id_pla, nombre, precio FROM platillo");
              while ($row = mysqli_fetch_assoc($platillosQuery)) {
                echo "<option value='{$row['id_pla']}' data-precio='{$row['precio']}'>" . htmlspecialchars($row['nombre']) . "</option>";
              }
              ?>
            </select>
          </td>
          <td><input type="number" name="cantidad[]" class="cantidad" required></td>
          <td><input type="number" name="precio[]" class="precioUnidad" step="0.01" readonly required></td>
          <td><input type="number" name="total[]" class="total" step="0.01" readonly></td>
          
          <!-- ✅ Campo oculto con la fecha -->
          <td>
            <span class="fecha-visible"></span>
            <input type="hidden" name="fecha[]" class="fecha-hidden">
          </td>

          <td><button type="button" class="eliminar-fila boton" onclick="eliminarFila(this)">🗑</button></td>
        </tr>

        </tbody>
        <tfoot>
          <tr>
            <td colspan="6" style="text-align: center;">
              <button type="button" onclick="agregarFila()" class="boton">+</button>
            </td>
          </tr>
          <tr>
            <td colspan="6" style="text-align: center;">
              <button type="submit" name="registrar" class="boton">GENERAR FACTURA</button>
            </td>
          </tr>
        </tfoot>
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'ok'): ?>
          <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 15px;">
            <?php
              if ($session->has('error_message')) {
                echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
                $session->remove('error_message');
              }
            ?>
          </div>
        <?php elseif (isset($_GET['error'])): ?>
          <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 15px;">
            ❌ Error: <?php echo htmlspecialchars($_GET['error']); ?>
          </div>
        <?php endif; ?>
      </table>
    </form>
  </div>
</div>
</main>

<script>
  const themeToggle = document.getElementById('themeToggle');
  themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
  });

  const perfilBtn = document.getElementById('perfilBtn');
  const perfilMenu = document.getElementById('perfilMenu');
  document.addEventListener('click', (e) => {
    if (!perfilBtn.contains(e.target) && !perfilMenu.contains(e.target)) {
      perfilMenu.style.display = 'none';
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    const filas = document.querySelectorAll("tr");

    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaActual = `${yyyy}-${mm}-${dd}`; // Formato YYYY-MM-DD

    filas.forEach(fila => {
      const spanFecha = fila.querySelector(".fecha-visible");
      const inputFecha = fila.querySelector(".fecha-hidden");
      if (spanFecha && inputFecha) {
        spanFecha.textContent = fechaActual;
        inputFecha.value = fechaActual;
      }
    });
  });

  function agregarFila() {
    const tabla = document.getElementById('ventaRows');
    const nuevaFila = tabla.rows[0].cloneNode(true);

    nuevaFila.querySelectorAll('input').forEach(input => input.value = '');
    nuevaFila.querySelector('select').selectedIndex = 0;

    tabla.appendChild(nuevaFila);
    actualizarEventos();
  }

  function eliminarFila(boton) {
    const fila = boton.closest('tr');
    const totalFilas = document.querySelectorAll('#ventaRows tr').length;

    if (totalFilas > 1) {
      fila.remove();
    } else {
      alert("Debe haber al menos una fila de venta.");
    }
  }

  function actualizarEventos() {
    const filas = document.querySelectorAll('#ventaRows tr');
    filas.forEach(fila => {
      const platillo = fila.querySelector('.platillo');
      const cantidad = fila.querySelector('.cantidad');
      const precio = fila.querySelector('.precioUnidad');
      const total = fila.querySelector('.total');

      platillo.onchange = () => {
        const selected = platillo.options[platillo.selectedIndex];
        const precioVal = parseFloat(selected.dataset.precio || 0);
        precio.value = precioVal.toFixed(2);
        calcularFila(cantidad, precio, total);
      };

      cantidad.oninput = () => calcularFila(cantidad, precio, total);
    });
  }

  function calcularFila(cantidadInput, precioInput, totalInput) {
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const precio = parseFloat(precioInput.value) || 0;
    totalInput.value = (cantidad * precio).toFixed(2);
  }

  actualizarEventos();


</script>

</body>
</html>
