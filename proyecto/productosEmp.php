<?php

require_once './php/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: login.php");
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Empleado</title>
  <link rel="stylesheet" href="./css/dashboard.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
   
</head>
<body>
  <!-- ░░░░░░░░░░  NAVBAR  ░░░░░░░░░░ -->
  <header class="navbar">
  

     <span class="logo-text">EMPLEADO</span>
    </div>

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

  <!-- ░░░░░░░░░░ CONTENIDO ░░░░░░░░░░ -->
  <div class="container">
    <!-- ░░░  SIDEBAR  ░░░ -->
    <aside class="menu-lateral">
  <nav class="menu-container">


    <div class="menu-item">
      <button class="btn-menu">Gestión de Productos</button>
      <div class="sub-menu">
        <a href="registerEmpPro.php" class="sub-btn">Registrar</a>
        <a href="productosEmp.php" class="sub-btn">Consultar</a>
      </div>
    </div>


    <div class="menu-item">
      <button class="btn-menu">Gestión de Proveedor</button>
      <div class="sub-menu">
        <a href="registerEmpProv.php" class="sub-btn">Registrar</a>
        <a href="proveedorEmp.php" class="sub-btn">Consultar</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="btn-menu">Gestión de Reservas</button>
      <div class="sub-menu">
        <a href="registerEmpRes.php" class="sub-btn">Registrar</a>
        <a href="reservasEmp.php" class="sub-btn">Consultar</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="btn-menu">Gestión de Platillos</button>
      <div class="sub-menu">
        <a href="ventas_registrar.html" class="sub-btn">Registrar</a>
        <a href="platilloEmp.php" class="sub-btn">Consultar</a>
      </div>
    </div>


  </nav>

    <div class="menu-item">
      <button class="btn-venta">HACER UNA VENTA</button>
    </div>


</aside>
     <!-- ░░░  MAIN  ░░░ -->
    

  <!-- ░░░░░░░░░░  SCRIPTS  ░░░░░░░░░░ -->
  <script>
  // Cargar preferencia guardada
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
  }

  const themeToggle = document.getElementById('themeToggle');
  themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
    
    // Guardar preferencia
    const isDark = document.body.classList.contains('dark-theme');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
  });



    // ----- Menú perfil desplegable -----
    const perfilBtn = document.getElementById('perfilBtn');
    const perfilMenu = document.getElementById('perfilMenu');
    perfilBtn.addEventListener('click', () => {
      perfilMenu.style.display = perfilMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
      if (!perfilBtn.contains(e.target) && !perfilMenu.contains(e.target)) {
        perfilMenu.style.display = 'none';
      }
    });

    // ----- Sub-menús laterales -----
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
      const button = item.querySelector('.btn-menu');
      const subMenu = item.querySelector('.sub-menu');
      button.addEventListener('click', () => {
        const isOpen = subMenu.style.display === 'flex';
        // Cierra otros submenús
        document.querySelectorAll('.sub-menu').forEach(sm => sm.style.display = 'none');
        if (!isOpen) {
          subMenu.style.display = 'flex';
        }
      });
    });

    // ----- Grafico Placeholder (Chart.js) -----
    // Solo un ejemplo para que puedas conectar tus datos reales
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
<div class="tabla-container">
    <h1 class="titulo">TABLA DE CONSULTA DE PRODUCTO</h1> 

<table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Categoria</th>
        <th>Imagen</th>
        <th>Precio</th>
    </tr>


<?php
// Assuming $conexion is already established
$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
$sql = "SELECT * FROM producto";
$result = mysqli_query($conexion, $sql);

while ($mostrar = mysqli_fetch_array($result)) {
  $ruta_completa_imagen = "img_producto/" . $mostrar['imagen'];
?>
    <tr>
        <td><?php echo $mostrar['id_producto']; ?></td>
        <td><?php echo $mostrar['nombre']; ?></td>
        <td><?php echo $mostrar['categoria']; ?></td>
        <td><?php echo "<img src='" . htmlspecialchars($ruta_completa_imagen) . " ' style='width:200px; height:auto;'>";?></td>
        <td><?php echo $mostrar['precio_unitario']; ?></td>
        <td>
            <a href="editarProdEmp.php?id=<?php echo $mostrar['id_producto'];?> &categoria=<?php echo $mostrar['categoria'];?> &nombre=<?php echo $mostrar['nombre'];?> &imagen=<?php echo $mostrar['imagen'];?>  &precio_unitario=<?php echo $mostrar['precio_unitario'];?>" class="boton-edi">Editar</a>

            <a href="./php/eliminarProdEmp.php?id=<?php echo $mostrar['id_producto']; ?>" class="boton" onclick="return confirm('¿Estás seguro de que quieres eliminar este empleado?');">Eliminar</a>
        </td>
    </tr>

    
<?php
}
?>
    </table>

    <td>
            <button class="btn-report" onclick="printReport()">GENERAR REPORTE / IMPRIMIR</button>
    </td>

</div>

</div>


<script>

       // --- FUNCIONALIDAD PARA IMPRIMIR/GENERAR REPORTE ---
function printReport() {
    // Abre una nueva ventana para imprimir solo el contenido de la tabla
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Reporte de Productos</title>');
    // Incluye CSS para la impresión. Puedes usar los mismos estilos de tabla o uno específico para impresión.
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('h1 { text-align: center; margin-bottom: 20px; }');
    // Oculta elementos que no quieres imprimir (ej. elementos con clase 'no-print')
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    // Agrega el título del reporte
    printWindow.document.write('<h1>Reporte de Productos Kenny\'s</h1>');

    // Copia el contenido de la tabla original
    const originalTable = document.querySelector('.tabla-container table');
    // Clona la tabla para poder modificarla sin afectar la tabla visible en la página
    const clonedTable = originalTable.cloneNode(true); // 'true' para clonar todos los hijos (incluyendo thead, tbody, tr, th, td, a, etc.)

    // --- LÓGICA PARA ELIMINAR LA COLUMNA COMPLETA DE ACCIONES ---

    // 1. Eliminar el encabezado 'Acciones' (el último <th>)
    const headerRow = clonedTable.querySelector('thead tr');
    if (headerRow) {
        const lastHeaderCell = headerRow.lastElementChild; // Obtiene el último <th>
        // Opcional: Puedes verificar que sea el <th> correcto si su texto es 'Acciones'
        // if (lastHeaderCell && lastHeaderCell.textContent.trim() === 'Acciones') {
            lastHeaderCell.remove(); // Elimina el <th>
        // }
    }

    // 2. Eliminar las celdas de acción de cada fila (el último <td> en cada <tr> del <tbody>)
    const bodyRows = clonedTable.querySelectorAll('tbody tr');
    bodyRows.forEach(row => {
        const lastBodyCell = row.lastElementChild; // Obtiene el último <td> de la fila
        if (lastBodyCell) {
            lastBodyCell.remove(); // Elimina el <td>
        }
    });

    // --- FIN DE LA LÓGICA PARA ELIMINAR LA COLUMNA COMPLETA DE ACCIONES ---

    // Escribe la tabla modificada (sin la columna de acciones) en la ventana de impresión
    printWindow.document.write(clonedTable.outerHTML);

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}

    </script>


</body>
</html>
