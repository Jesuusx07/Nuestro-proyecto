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
  <title>Panel Administrativo</title>
  <link rel="stylesheet" href="./css/dashboard.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
   
</head>
<body>
  <!-- ░░░░░░░░░░  NAVBAR  ░░░░░░░░░░ -->
  <header class="navbar">
  

       <a href="dashboard.php" class="logo-text">ADMINISTRADOR</a>
    </div>

    <div class="navbar-right">
      <button id="themeToggle" title="Cambiar tema claro/oscuro">🌓</button>
      
      <div class="perfil">
        <button class="boton-perfil" id="perfilBtn">👤</button>
       <div class="menu-desplegable" id="perfilMenu">

  <a href="./Rutas/logout.php"><span>🔓</span> Cerrar sesión</a>
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
                <div class="menu-item">
          <button class="btn-menu">Gestión de Facturas</button>
          <div class="sub-menu">
            <a href="Facturas.php" class="sub-btn">Consultar</a>
          </div>
        </div>
      </nav>
  <form id="formu" action="./venta_empleado.php" method="POST"> 
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
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>


<?php
// Assuming $conexion is already established
$conexion = mysqli_connect("kennys.online", "u112415144_kenny", "Kennys12345", "u112415144_proyecto_kenny");
$sql = "SELECT p.id_producto,
                p.nombre,
                p.categoria,
                p.imagen,
                p.precio_unitario,
                u.correo
            FROM 
                producto p
            JOIN
                usuario u ON p.id_usuario = u.id_usuario";
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
        <td><?php echo $mostrar['correo']; ?></td>        

        <td>
            <a href="editar_producto.php?id=<?php echo $mostrar['id_producto'];?> &categoria=<?php echo $mostrar['categoria'];?> &nombre=<?php echo $mostrar['nombre'];?> &imagen=<?php echo $mostrar['imagen'];?>  &precio_unitario=<?php echo $mostrar['precio_unitario'];?>" class="boton-edi">Editar</a>
        </td>
        <td>
            <a href="./Rutas/eliminarPro.php?id=<?php echo $mostrar['id_producto']; ?>" class="boton" onclick="return confirm('¿Estás seguro de que quieres eliminar este empleado?');">Eliminar</a>
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
    printWindow.document.write('<html><head><title>Reporte de Producto</title>');

    // Incluye CSS para la impresión
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('h1 { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');

    printWindow.document.write('</head><body>');

    // Agrega el título del reporte
    printWindow.document.write('<h1>Reporte de Productos Kenny\'s</h1>');

    // Copia el contenido de la tabla original
    const originalTable = document.querySelector('.tabla-container table');
    const clonedTable = originalTable.cloneNode(true); // Clona la tabla completa

    // --- ELIMINAR LAS DOS ÚLTIMAS COLUMNAS DE CADA FILA ---
    const allRows = clonedTable.querySelectorAll('tr');
    allRows.forEach(row => {
        for (let i = 0; i < 2; i++) {
            if (row.lastElementChild) {
                row.lastElementChild.remove();
            }
        }
    });

    // Agrega la tabla modificada al documento
    printWindow.document.write(clonedTable.outerHTML);

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}

  </script>

</body>
</html>
