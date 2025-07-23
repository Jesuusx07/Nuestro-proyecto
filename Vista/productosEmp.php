<?php

require_once '../Config/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: ../Vista/login.php");
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
  
    <a href="dashboard.php" class="logo-text">EMPLEADO</a>
    <div class="navbar-right">
      <button id="themeToggle" title="Cambiar tema claro/oscuro">🌓</button>
      <div class="perfil">
        <button class="boton-perfil" id="perfilBtn">👤 Perfil</button>
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
            <button class="btn-menu">Gestión de Inventario</button>
            <div class="sub-menu">
              <a href="registerEmpInv.php" class="sub-btn">Registrar</a>
              <a href="inventarioEmp.php" class="sub-btn">Consultar</a>
            </div>
      </div>

          <div class="menu-item">
            <button class="btn-menu">Gestión de Producto</button>
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
            <button class="btn-menu">Gestión de Platillo</button>
            <div class="sub-menu">
              <a href="registrarPlatilloEmp.php" class="sub-btn">Registrar</a>
              <a href="platilloEmp.php" class="sub-btn">Consultar</a>
            </div>
          </div>

    </nav>

        <form id="formu" action="venta_empleado.php" method="POST"> 
          <div class="menu-item"> 
            <button class="btn-venta">HACER UNA VENTA</button>
          </div>
      </form>
  </aside>
     <!-- ░░░  MAIN  ░░░ -->
    
<div class="tabla-container">
    <h1 class="titulo">TABLA DE CONSULTA DE PRODUCTO</h1> 

  <table>
      <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Categoria</th>
          <th>Imagen</th>
          <th>Precio</th>
          <th>Proveedor</th>
          <th>Acciones</th>
      </tr>


  <?php
  // Assuming $conexion is already established
  $conexion = mysqli_connect("151.106.96.29", "root", "", "u112415144_proyecto_kenny");
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
          <td><?php echo $mostrar['id_usuario']; ?></td>        

          <td>
              <a href="../Rutas/editarProdEmp.php?id=<?php echo $mostrar['id_producto'];?> &categoria=<?php echo $mostrar['categoria'];?> &nombre=<?php echo $mostrar['nombre'];?> &imagen=<?php echo $mostrar['imagen'];?>  &precio_unitario=<?php echo $mostrar['precio_unitario'];?>" class="boton-edi">Editar</a>
              <a href="../Rutas/eliminarProdEmp.php?id=<?php echo $mostrar['id_producto']; ?>" class="boton" onclick="return confirm('¿Estás seguro de que quieres eliminar este empleado?');">Eliminar</a>
          </td>
      </tr>
  <?php
  }
  ?>
  </table>
  <button class="btn-report" onclick="printReport()">GENERAR REPORTE / IMPRIMIR</button>
    
</div>
  
</div>

<!-- ░░░░░░░░░░  SCRIPTS  ░░░░░░░░░░ -->
  <script>
    // ----- Tema claro / oscuro -----
   if (localStorage.getItem('darkTheme') === 'enabled') {
      document.body.classList.add('dark-theme');
    }

    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme');
      const isDark = document.body.classList.contains('dark-theme');
      localStorage.setItem('darkTheme', isDark ? 'enabled' : 'disabled');
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
      const clonedTable = originalTable.cloneNode(true); // 'true' para clonar todos los hijos

      // --- LÓGICA PARA ELIMINAR SOLO LA COLUMNA DE ACCIONES (LA ÚLTIMA) ---

      // 1. Eliminar el último encabezado (<th>) de la fila de encabezados
      const headerRow = clonedTable.querySelector('thead tr');
      if (headerRow) {
          // Elimina el último <th> (que es "Acciones")
          if (headerRow.lastElementChild) {
              headerRow.lastElementChild.remove();
          }
          // Eliminamos la segunda llamada a .remove() que causaba que se borrara "Proveedor"
      }

      // 2. Eliminar la última celda (<td>) de cada fila del cuerpo de la tabla
      const bodyRows = clonedTable.querySelectorAll('tbody tr');
      bodyRows.forEach(row => {
          // Elimina la última <td> (que contiene los botones Editar y Eliminar)
          if (row.lastElementChild) {
              row.lastElementChild.remove();
          }
          // Eliminamos la segunda llamada a .remove() que causaba que se borrara el valor de "Proveedor"
      });

      // --- FIN DE LA LÓGICA PARA ELIMINAR SOLO LA COLUMNA DE ACCIONES ---

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
