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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Kenny's</title>
  <link rel="stylesheet" href="./css/dashboardEmp.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <div class="navbar">
    <div class="navbar-left">
      <a href="index.html"><img src="./img/logo_Favicon.png" alt=""></a>
      <span>EMPLEADO</span>
      <button class="boton-perfil" onclick="toggleMenu()">👤 Perfil</button>
    </div>
  </div>

  <div class="perfil">
   <div class="menu-desplegable" id="menuPerfil">
   <a href="./php/logout.php"><span>🔓</span> Cerrar sesión</a>
  </div>
  
</div>

<script>
  function toggleMenu() {
    const menu = document.getElementById("menuPerfil");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }

  window.onclick = function(event) {
    if (!event.target.matches('.boton-perfil')) {
      const menu = document.getElementById("menuPerfil");
      if (menu.style.display === "block") {
        menu.style.display = "none";
      }
    }
  }

</script>


  <div class="container">
    
    <div class="menu-lateral">
      <div class="menu-container">

        <div class="menu-item">
          <button class="btn-menu">GESTIÓN DE <br>PEDIDO</button>
          <div class="sub-menu">
            <a href="pedidoEmp.php" class="sub-btn">Consultar</a>
            <a href="1EmpPedido.php" class="sub-btn">Registrar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">GESTIÓN DE <br>PRODUCTOS</button>
          <div class="sub-menu">
            <a href="productosEmp.php" class="sub-btn">Consultar</a>
            <a href="1EmpPedido.php" class="sub-btn">Registrar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">GESTIÓN DE <br>PROVEEDOR</button>
          <div class="sub-menu">
            <a href="proveedorEmp.php" class="sub-btn">Consultar</a>
            <a href="1EmpPedido.php" class="sub-btn">Registrar</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="btn-menu">GESTIÓN DE <br>RESERVAS</button>
          <div class="sub-menu">
            <a href="reservasEmp.php" class="sub-btn">Consultar</a>
            <a href="1EmpPedido.php" class="sub-btn">Registrar</a>
          </div>
        </div>
    
      </div>
    </div>

    <div class="main">
      <div class="welcome-box">
        <h2>Buenos Días, <span id="$nom">Usuario</span></h2>
        <p>Tomate un momento para ver tus <span class="highlight">estadísticas</span> generales :D</p>

        <div class="ventas-y-graficos">
          <div class="ventas-lista">
            <div class="ventas-item"><span>Ventas Diarias</span></div>
            <div class="ventas-item"><span>Ventas Semanales</span></div>
            <div class="ventas-item"><span>Ventas Mensuales</span></div>
            <div class="ventas-item"><span>Ventas Anuales</span></div>
          </div>

          <div class="stat-box dual">
            <div class="column">
              <h3>Domicilios Semanales</h3>
              <div class="arrow">⇈</div>
              <div class="stat-number" id="semanaContador">14/30</div>
              <p class="dias">Lunes-- Martes-- Miércoles-- Jueves-- Viernes-- Sábado-- Domingo</p>
              <canvas id="graficoSemanal"></canvas>
            </div>
            <div class="column">
              <h3>Domicilios <br> Diarios</h3>
              <div class="arrow">⇈</div>
              <div class="stat-number" id="diaContador">3/5</div>
              <p class="dias">Lunes-- Martes-- Miércoles-- Jueves-- Viernes-- Sábado-- Domingo</p>
              <canvas id="graficoDiario"></canvas>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    const menuItems = document.querySelectorAll('.menu-item');
              
              menuItems.forEach(item => {
                const btnMenu = item.querySelector('.btn-menu');
                const subMenu = item.querySelector('.sub-menu');
            
                btnMenu.addEventListener('click', () => {
                  // Cierra cualquier otro submenú abierto
                  menuItems.forEach(otherItem => {
                    if (otherItem !== item) {
                      const otherSubMenu = otherItem.querySelector('.sub-menu');
                      if (otherSubMenu) {
                        otherSubMenu.style.display = 'none';
                      }
                    }
                  });
            
                  // Alterna la visibilidad del submenú actual
                  if (subMenu) {
                    subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block';
                  }
                });
              });

    new Chart(document.getElementById("graficoSemanal"), {
      type: "line",
      data: {
        labels: ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        datasets: [{
          label: "Domicilios",
          data: [2, 3, 1, 4, 2, 1, 1],
          backgroundColor: "rgba(192, 57, 43, 0.3)",
          borderColor: "#c0392b",
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointBackgroundColor: "#c0392b"
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });

    new Chart(document.getElementById("graficoDiario"), {
      type: "line",
      data: {
        labels: ["8am", "10am", "12pm", "2pm", "4pm"],
        datasets: [{
          label: "Domicilios",
          data: [0, 1, 2, 0, 0],
          backgroundColor: "rgba(52, 152, 219, 0.3)",
          borderColor: "#3498db",
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointBackgroundColor: "#3498db"
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>

  <script>
  const nombreUsuario = localStorage.getItem('nombre');
  if (nombreUsuario) {
    document.getElementById('$nom').textContent = nombreUsuario;
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


</body>
</html>