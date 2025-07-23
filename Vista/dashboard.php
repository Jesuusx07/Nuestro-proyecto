<?php
require_once '../Config/SessionManager.php';
$session = new SessionManager();

if (!$session->isLoggedIn()) {
    header("location: ../Vista/login.php");
    exit();
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

  <!-- ░░░░░░░░░░  NAVBAR  ░░░░░░░░░░ -->
  <header class="navbar">
    <a href="dashboard.php" class="logo-text">ADMINISTRADOR</a>
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
    <main class="main">
      <section class="welcome-box">
        <?php
        $usuarioConectado = $session->getUserName();
        $conexion = mysqli_connect("151.106.96.29", "root", "", "u112415144_proyecto_kenny");
        $sql = "SELECT * FROM usuario WHERE correo = '$usuarioConectado'";
        $result = mysqli_query($conexion, $sql);
        while ($mostrar = mysqli_fetch_array($result)) {
        ?>
        <h2>¡Bienvenido, <span class="highlight"><?php echo $mostrar['nombres']; ?></span>!</h2>
        <?php } ?>
        <p>Hoy es <?php echo date('d/m/Y'); ?>.</p>
        <p>Este es tu panel administrativo, donde podrás visualizar y gestionar la información principal de tu negocio.</p>

        <div class="ventas-y-graficos">
          <div class="stat-box">
            <span class="stat-number">$12.5K</span>
            <div class="arrow">▲ 8%</div>
            <div class="dias">Ventas esta semana</div>
          </div>
          

          <div class="stat-box dual">
            <div class="column">
              <h3>152</h3>
              <p>Productos vendidos</p>
            </div>
            <div class="column">
              <h3>
                <?php
                $consulta = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM usuario WHERE id_rol = 'empleado'");
                $fila = mysqli_fetch_assoc($consulta);
                echo $fila['total'];
                ?>
              </h3>
              <p>Nuevos Empleados</p>
            </div>
          </div>

          <div class="stat-box" style="flex:1 1 200px;">
          

           <h2 class="titulo-empleados">Lista de Empleados</h2>
<div class="tabla-empleados">
  <table>
    <thead>
      <tr>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Documento</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM usuario WHERE id_rol NOT IN ('admin', 'proveedor', 'cliente')";
      $result = mysqli_query($conexion, $sql);
      while ($mostrar = mysqli_fetch_array($result)) {
      ?>
      <tr>
        <td><?= htmlspecialchars($mostrar['nombres']) ?></td>
        <td><?= htmlspecialchars($mostrar['apellidos']) ?></td>
        <td><?= htmlspecialchars($mostrar['correo']) ?></td>
        <td><?= htmlspecialchars($mostrar['telefono']) ?></td>
        <td><?= htmlspecialchars($mostrar['documento']) ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<!-- ░░░ CONSULTA DE RESERVAS ░░░ -->

          </div>
          <div class="tabla-container">
  <h1 class="titulo">TABLA DE CONSULTA DE RESERVA</h1>

  <table>
    <thead>
      <tr>
        <th>Reserva</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Nombre Cliente</th>
        <th>Apellido Cliente</th>
        <th>Usuario Responsable</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sqlReserva = "SELECT
          r.id_reserva,
          r.estado_reserva,
          r.fecha_reserva,
          r.responsable,
          u.nombres,
          u.apellidos,
          u.correo
        FROM
          reserva r
        JOIN
          usuario u ON r.cliente = u.correo
        WHERE
          u.id_rol = 'cliente'";

      $resultReserva = mysqli_query($conexion, $sqlReserva);

      while ($mostrar = mysqli_fetch_array($resultReserva)) {
      ?>
        <tr>
          <td><?php echo $mostrar['id_reserva']; ?></td>
          <td><?php echo $mostrar['estado_reserva']; ?></td>
          <td><?php echo $mostrar['fecha_reserva']; ?></td>
          <td><?php echo $mostrar['nombres']; ?></td>
          <td><?php echo $mostrar['apellidos']; ?></td>
          <td><?php echo $mostrar['responsable']; ?></td>
          <td>
         
      
      <?php } ?>
        </div>
      </section>
    </main>
  </div>

  <!-- ░░░░░░░░░░  SCRIPTS  ░░░░░░░░░░ -->
  <script>
    if (localStorage.getItem('darkTheme') === 'enabled') {
      document.body.classList.add('dark-theme');
    }

    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme');
      const isDark = document.body.classList.contains('dark-theme');
      localStorage.setItem('darkTheme', isDark ? 'enabled' : 'disabled');
    });

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
  </script>

  
  <?php
  require_once 'php/SessionManager.php';
  $session = new SessionManager();
  $timeout_seconds = $session->getTimeoutSeconds();
  ?>

  <script>
    const INACTIVITY_TIMEOUT = <?php echo $timeout_seconds * 5000; ?>;
    let inactivityTimer;

    function resetInactivityTimer() {
      clearTimeout(inactivityTimer);
      inactivityTimer = setTimeout(logoutUser, INACTIVITY_TIMEOUT);
    }

    function logoutUser() {
      alert('Su sesión ha caducado por inactividad. Por favor, inicie sesión de nuevo.');
      window.location.href = 'login.php?message=session_expired';
    }

    document.addEventListener('mousemove', resetInactivityTimer);
    document.addEventListener('keypress', resetInactivityTimer);
    document.addEventListener('click', resetInactivityTimer);
    document.addEventListener('scroll', resetInactivityTimer);

    resetInactivityTimer();
  </script>

</body>
</html>
