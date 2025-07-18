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
  

     <span class="logo-text">ADMINISTRADOR</span>
    
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
<<<<<<< HEAD
=======
<<<<<<< HEAD

            <a href="registerUs.php" class="sub-btn">Registrar</a>
            <a href="registrarPlatillo.php" class="sub-btn">Consultar</a>
=======
 
>>>>>>> 5bc0c6e192c08c9ea23b3fdecf44eab38fcd8e20

            <a href="registrarPlatillo.php" class="sub-btn">Registrar</a>
            <a href="platilloAdmin.php" class="sub-btn">Consultar</a>
>>>>>>> 1b812118b910a719d5b5f2f9fcb260314841a14d
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">Gestión de Producto</button>
          <div class="sub-menu">
<<<<<<< HEAD
=======
<<<<<<< HEAD
            <a href="registerUs.php" class="sub-btn">Registrar</a>
            <a href="registrarPlatillo.php" class="sub-btn">Consultar</a>

            <a href="registrarPlatillo.php" class="sub-btn">Registrar</a>
            <a href="platillo.php" class="sub-btn">Consultar</a>

          </div>
=======
            <a href="registrarProductos.php" class="sub-btn">Registrar</a>

        </div>
>>>>>>> 1b812118b910a719d5b5f2f9fcb260314841a14d
        </div>
           <div class="menu-item">
          <button class="btn-menu">Gestión de Productos </button>
          <div class="sub-menu">
>>>>>>> 5bc0c6e192c08c9ea23b3fdecf44eab38fcd8e20
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
          <button class="btn-menu">Gestión de Ventas</button>
          <div class="sub-menu">
            <a href="ventasRegis.php" class="sub-btn">Registrar</a>
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
$conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
$sql = "SELECT * FROM usuario WHERE correo = '$usuarioConectado'";
$result = mysqli_query($conexion, $sql);

while ($mostrar = mysqli_fetch_array($result)) {
?>
<h2>¡Bienvenido, <span class="highlight"><?php echo $mostrar['nombres'];?></span>!</h2>
<?php
}
?>
          
          <p>Hoy es <?php echo date('d/m/Y'); ?>.</p> 
          



        <p>Este es tu panel administrativo, donde podrás visualizar y gestionar la información principal de tu negocio.</p>

        <div class="ventas-y-graficos">
          <!-- Stat box ejemplo -->
          <div class="stat-box">
            <span class="stat-number">$12.5K</span>
            <div class="arrow">▲ 8%</div>
            <div class="dias">Ventas esta semana</div>
          </div>

          <!-- Stat box dual ejemplo -->
          <div class="stat-box dual">
            <div class="column">
              <h3>152</h3>
              <p>Productos vendidos</p>
            </div>
            <div class="column">
              <h3>38</h3>
              <p>Nuevos clientes</p>
            </div>
          </div>

          <!-- Placeholder para gráfico -->
          <div class="stat-box" style="flex:1 1 400px;">
            <canvas id="graficoVentas"></canvas>
            
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- ░░░░░░░░░░  SCRIPTS  ░░░░░░░░░░ -->
  <script>
    // ----- Tema claro / oscuro -----
  // Detectar y aplicar el tema guardado al cargar
if (localStorage.getItem('darkTheme') === 'enabled') {
  document.body.classList.add('dark-theme');
}

// Botón para alternar tema
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

  <?php
    // Incluye tu SessionManager en cada página protegida
    require_once 'php/SessionManager.php';
    $session = new SessionManager();


    // Obtiene el tiempo de inactividad desde la clase SessionManager
    $timeout_seconds = $session->getTimeoutSeconds();
    ?>

    <script type="text/javascript">
        // Tiempo de inactividad en milisegundos (del servidor)
        const INACTIVITY_TIMEOUT = <?php echo $timeout_seconds * 5000; ?>; // Convertir a milisegundos

        let inactivityTimer;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(logoutUser, INACTIVITY_TIMEOUT);
        }

        function logoutUser() {
            alert('Su sesión ha caducado por inactividad. Por favor, inicie sesión de nuevo.');
            window.location.href = 'login.php?message=session_expired'; // Redirige al login con un mensaje
        }

        // Eventos que reinician el temporizador (cualquier actividad del usuario)
        document.addEventListener('mousemove', resetInactivityTimer);
        document.addEventListener('keypress', resetInactivityTimer);
        document.addEventListener('click', resetInactivityTimer);
        document.addEventListener('scroll', resetInactivityTimer); // Opcional: si el scroll cuenta como actividad

        // Inicia el temporizador cuando la página carga
        resetInactivityTimer();
    </script>

  <!-- Agrega Chart.js desde CDN si lo necesitas -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
</body>
</html>
