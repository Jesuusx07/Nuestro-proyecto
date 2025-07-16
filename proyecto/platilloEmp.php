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
      <button class="btn-menu">Gestión de Platillo</button>
      <div class="sub-menu">
        <a href="registrarPlatilloEmp.php" class="sub-btn">Registrar</a>
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
    // ----- Tema claro / oscuro -----
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

    
  </script>
<div class="tabla-container">
    <h1 class="titulo">TABLA DE CONSULTA DE PLATILLOS</h1> 

<table>
    <tr>
        <th>Id</th>
        <th>Nombres</th>
        <th>Descripcion</th>
        <th>Precio</th>
        <th>Categoria</th>
    </tr>


<?php
// Assuming $conexion is already established
$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
$sql = "SELECT * FROM platillo";
$result = mysqli_query($conexion, $sql);

while ($mostrar = mysqli_fetch_array($result)) {
?>
    <tr>
        <td><?php echo $mostrar['id_pla']; ?></td>
        <td><?php echo $mostrar['nombre']; ?></td>
        <td><?php echo $mostrar['descripcion']; ?></td>
        <td><?php echo $mostrar['precio']; ?></td>
        <td><?php echo $mostrar['pla_categoria']; ?></td>
        <td>
            <a href="editarPlaEmp.php?id_pla=<?php echo htmlspecialchars($mostrar['id_pla']); ?>&nombre=<?php echo htmlspecialchars($mostrar['nombre']); ?>&descripcion=<?php echo htmlspecialchars($mostrar['descripcion']); ?>&precio=<?php echo htmlspecialchars($mostrar['precio']); ?>&pla_categoria=<?php echo htmlspecialchars($mostrar['pla_categoria']); ?>" class="boton-edi">Editar</a>
        </td>
        <td>
            <a href="./php/eliminarPlaEmp.php?id_pla=<?php echo htmlspecialchars($mostrar['id_pla']); ?>" class="boton" onclick="return confirm('¿Estás seguro de que quieres eliminar este platillo?');">Eliminar</a>
        </td>
    </tr>
<?php
}
?>
    </table>
</div>

    </table>
</div>
</body>
</html>
