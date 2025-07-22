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
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Administrativo</title>
  <link rel="stylesheet" href="./css/dashboard.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
  <!-- NAVBAR -->
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

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="container">
    <!-- SIDEBAR -->
    <aside class="menu-lateral">
      <nav class="menu-container">
 <div class="menu-item">
          <button class="btn-menu">Gestión de Empleados</button>
          <div class="sub-menu">
            <a href="registerUs.php" class="sub-btn">Registrar</a>
            <a href="empleado.php" class="sub-btn">Consultar</a>
          </div>
        </div>

      <div class="menu-item">
          <button class="btn-menu">Gestión de Platillos</button>
          <div class="sub-menu">
            <a href="registrarPlatillo.php" class="sub-btn">Registrar</a>
            <a href="platilloAdmin.php" class="sub-btn">Consultar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">Gestión de Producto</button>
          <div class="sub-menu">
            <a href="registrarProducto.php" class="sub-btn">Registrar</a>
            <a href="Producto.php" class="sub-btn">Consultar</a>
          </div>
        </div>
    
        <div class="menu-item">
          <button class="btn-menu">Gestión de Proveedor</button>
          <div class="sub-menu">
            <a href="registrarproveedores.php" class="sub-btn">Registrar</a>
            <a href="proveedores.php" class="sub-btn">Consultar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">Gestión de Reservas</button>
          <div class="sub-menu">
            <a href="reservasRegis.php" class="sub-btn">Registrar</a>
            <a href="reservas.php" class="sub-btn">Consultar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">Historial de Ventas</button>
          <div class="sub-menu">
            
            <a href="ventas.php" class="sub-btn">Consultar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">Gestión de Inventario</button>
          <div class="sub-menu">
            <a href="inventarioRegis.php" class="sub-btn">Registrar</a>
            <a href="inventario.php" class="sub-btn">Consultar</a>
          </div>
        </div>
      </nav>
     <form id="formu" action="./venta_empleado.php" method="POST"> 
        <div class="menu-item"> 
          <button class="btn-venta">HACER UNA VENTA</button>
        </div>
    </form>
    </aside>

    <!-- TABLA DE INVENTARIO -->
    <main class="tabla-container">
      <h1 class="titulo">TABLA DE CONSULTA DE INVENTARIO</h1>

      <table>
        <tr>
          <th>id_inventario</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Tipo_de_movimiento</th>
          <th>Fecha</th>
          <th>Usuario responsable</th>     
        </tr>

        <?php
        $conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
        $sql = "SELECT i.id_inventario, 
                       i.id_producto,  
                       p.nombre,
                       i.cantidad, 
                       i.tipo_de_movimiento, 
                       i.fecha, 
                       i.responsable 
                    FROM 
                       inventario i
                    JOIN
                       producto p ON i.id_producto = p.id_producto";

        $result = mysqli_query($conexion, $sql);

        $sql_cantidad = " SELECT
                          p.nombre,
                          i.cantidad_total
                      FROM
                          inventario i
                      JOIN
                          producto p ON i.id_producto = p.id_producto
                      GROUP BY
                          p.id_producto, p.nombre -- Agrupamos por ID y nombre para asegurar unicidad y que el nombre sea correcto
                      ORDER BY
                          p.nombre ASC; ";
        $result_sum = mysqli_query($conexion, $sql_cantidad);


        while ($mostrar = mysqli_fetch_array($result)) {
        ?>
        <tr>
          <td><?php echo $mostrar['id_inventario']; ?></td>
          <td><?php echo $mostrar['nombre']; ?></td>
          <td><?php echo $mostrar['cantidad']; ?></td>
          <td><?php echo $mostrar['tipo_de_movimiento']; ?></td>
          <td><?php echo $mostrar['fecha']; ?></td>
          <td><?php echo $mostrar['responsable']; ?></td>         
          <td>
              <a href="./php/eliminarInventario.php?id_inventario=<?php echo $mostrar['id_inventario']; ?> &producto=<?php echo $mostrar['id_producto']; ?>" class="boton" onclick="return confirm('¿Estás seguro de que quieres eliminar este inventario?');">Eliminar</a>
          </td>
        </tr>
        <?php
        }
        mysqli_free_result($result); // Free the result set from the inventory query
        ?>
        <tr>
          <th>Producto</th>
          <th>Cantidad total</th>          
        </tr>
      <tbody>
        <?php
        // Iterar y mostrar la suma total para cada producto
        while ($mostrar_total = mysqli_fetch_array($result_sum)) {
        ?>
        <tr>
          <td><?php echo $mostrar_total['nombre']; ?></td>
          <td><?php echo $mostrar_total['cantidad_total']; ?></td>
        </tr>
        <?php
        }
        mysqli_free_result($result_sum); // Liberar el conjunto de resultados
        ?>
      </tbody>
    </table>
          <?php
          if ($session->has('error_message')) {
            echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
            $session->remove('error_message');
          }
          ?>
      </table>
    </main>
  </div>

  <!-- SCRIPTS -->
  <script>
    // Tema claro/oscuro
    const themeToggle = document.getElementById("themeToggle");
    themeToggle.addEventListener("click", () => {
      document.body.classList.toggle("dark-theme");
    });

    // Menú perfil
    const perfilBtn = document.getElementById('perfilBtn');
    const perfilMenu = document.getElementById('perfilMenu');
    perfilBtn.addEventListener('click', () => {
      perfilMenu.style.display = perfilMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!perfilBtn.contains(e.target) && !perfilMenu.contains(e.target)) {
        perfilMenu.style.display = 'none';
      }
    });

    // Submenús laterales
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
      const button = item.querySelector('.btn-menu');
      const subMenu = item.querySelector('.sub-menu');
      button.addEventListener('click', () => {
        const isOpen = subMenu.style.display === 'flex';
        document.querySelectorAll('.sub-menu').forEach(sm => sm.style.display = 'none');
        if (!isOpen) {
          subMenu.style.display = 'flex';
        }
      });
    });

    // Gráfico de ejemplo (Chart.js)
    if (typeof Chart !== 'undefined') {
      const ctx = document.getElementById('graficoVentas');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
          datasets: [{
            label: 'Ventas',
            data: [12, 19, 3, 5, 2, 3, 7],
            fill: false,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    }
  </script>
</body>
</html>
