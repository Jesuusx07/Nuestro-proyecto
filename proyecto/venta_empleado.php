<?php
// 1. Verifica si el usuario ha iniciado sesión, si no, lo redirige a login.php
require_once './php/SessionManager.php';
$session = new SessionManager();

if (!$session->isLoggedIn()) {
    header("location: login.php");
    exit();
}

// 2. Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
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

<!-- 3. Barra de navegación superior -->
<header class="navbar">
  <span class="logo-text">ADMINISTRADOR</span>
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

    <!-- 6. Tabla que contiene el formulario y las ventas registradas -->
    <table>
      <thead>
        <tr>
          <th>ID Venta</th>
          <th>Platillo</th>
          <th>Cantidad</th>
          <th>Precio Unidad</th>
          <th>Precio Total</th>
        </tr>
      </thead>

      <tbody>
        <!-- FORMULARIO DE REGISTRO DE VENTA -->
        <form action="./php/factura.php" method="POST">
          <tr>
            <td>Auto</td>
            <td>
              <select name="id_pla" id="platillo" required>
                <option value="">Seleccione...</option>
                <?php
                // Cargar platillos con precio
                $platillosQuery = mysqli_query($conexion, "SELECT id_pla, nombre, precio FROM platillo");
                while ($row = mysqli_fetch_assoc($platillosQuery)) {
                  echo "<option value='{$row['id_pla']}' data-precio='{$row['precio']}'>" . htmlspecialchars($row['nombre']) . "</option>";
                }
                ?>
              </select>
            </td>
            <td><input type="number" name="cantidad" placeholder="Cantidad" required></td>
            <td><input type="number" name="precio" id="precioUnidad" step="0.01" placeholder="$" readonly required></td>
            <td><input type="number" name="total" step="0.01" placeholder="$" readonly></td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: center;">
              <button type="submit" class="boton">REGISTRAR VENTA</button>
            </td>
          </tr>
        </form>

        <!-- MOSTRAR REGISTROS DE VENTAS -->
        <?php
        $sql = "SELECT v.id_venta, 
                       p.nombre, 
                       v.cantidad, 
                       p.precio, 
                       v.precio_total
                FROM venta v
                JOIN platillo p ON v.id_pla = p.id_pla";
        $result = mysqli_query($conexion, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$row['id_venta']}</td>
                  <td>" . htmlspecialchars($row['nombre']) . "</td>
                  <td>{$row['cantidad']}</td>
                  <td>" . number_format($row['precio'], 2) . "</td>
                  <td>" . number_format($row['precio_total'], 2) . "</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</main>

<!-- SCRIPTS -->
<script>
  // Cambiar tema
  const themeToggle = document.getElementById('themeToggle');
  themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
  });

  // Cerrar menú perfil
  const perfilBtn = document.getElementById('perfilBtn');
  const perfilMenu = document.getElementById('perfilMenu');
  document.addEventListener('click', (e) => {
    if (!perfilBtn.contains(e.target) && !perfilMenu.contains(e.target)) {
      perfilMenu.style.display = 'none';
    }
  });

  // Calcular precio total automáticamente
  const platilloSelect = document.getElementById('platillo');
  const cantidadInput = document.querySelector('input[name="cantidad"]');
  const precioInput = document.querySelector('input[name="precio"]');
  const totalInput = document.querySelector('input[name="total"]');

  platilloSelect.addEventListener('change', () => {
    const selectedOption = platilloSelect.options[platilloSelect.selectedIndex];
    const precio = parseFloat(selectedOption.dataset.precio || 0);
    precioInput.value = precio.toFixed(2);
    calcularTotal();
  });

  cantidadInput.addEventListener('input', calcularTotal);
  precioInput.addEventListener('input', calcularTotal);

  function calcularTotal() {
    const cantidad = parseInt(cantidadInput.value) || 0;
    const precio = parseFloat(precioInput.value) || 0;
    const total = cantidad * precio;
    totalInput.value = total.toFixed(2);
  }
</script>

</body>
</html>
