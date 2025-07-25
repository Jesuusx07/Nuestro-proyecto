<?php

require_once './php/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: login.php");
    }

?>
<?php
require_once './php/SessionManager.php';
$session = new SessionManager();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar usuario</title>
  <link rel="stylesheet" href="./css/registerUs.css">
   <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
</head>
<body>
<header class="navbar">
  

     <span class="logo-text">ADMINISTRADOR</span>
    </div>

    <div class="navbar-right">
      <button id="themeToggle" title="Cambiar tema claro/oscuro">🌓</button>
      
      <div class="perfil">
        <button class="boton-perfil" id="perfilBtn">👤</button>
        <div class="menu-desplegable" id="perfilMenu">
   
          <a href="#">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </header>


  <div class="form">
    <h2>Registrar Inventario</h2>
    <div class="regis">
<<<<<<< HEAD
      <form id="formu" action="./Rutas/registerInventario.php" method="POST">
=======
      <form id="formu" action="../Rutas/registerInventario.php" method="POST">
>>>>>>> 67da95da794188e84d41f98f008e259865f2bd1e

        <label for="producto">Producto</label>
            <select id="tipo" name="producto">
                <option value=""></option>
          <?php

          $conexion = mysqli_connect("kennys.online", "u112415144_kenny", "Kennys12345", "u112415144_proyecto_kenny");
          $sql = "SELECT * FROM producto";
          $result = mysqli_query($conexion, $sql);

          while ($mostrar = mysqli_fetch_array($result)) {
          ?>

                <option value=<?php echo htmlspecialchars($mostrar['id_producto']); ?>><?php echo htmlspecialchars($mostrar['nombre']); ?></option>

          <?php
          }
          ?>
            </select>

            <input type="number" id="nombre" name="cantidad" placeholder="Cantidad" min="1" max="100" required>
            

            <label for="tipo">Tipo de movimiento</label>
                  <select id="tipo" name="tipo">
                    <option value=""></option>                    
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                  </select>
            <label for="tipo">Fecha</label>
            <input type="datetime-local" id="imagen" name="date">
            
            <input type="submit" id="boton" value="Registrar">

                <?php
                  if ($session->has('error_message')) {
                    echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
                    $session->remove('error_message');
                  } else if ($session->has('exito')) {
                    echo '<p class="exito">' . htmlspecialchars($session->get('exito')) . '</p>';
                    $session->remove('exito');
                    $session->remove('error_message');
                  }
                ?>
      </form>
    </div>
  </div>

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
    const perfilBtn = document.getElementById("perfilBtn");
    const perfilMenu = document.getElementById("perfilMenu");
    const themeToggle = document.getElementById("themeToggle");

    perfilBtn.addEventListener("click", () => {
      perfilMenu.style.display = perfilMenu.style.display === "block" ? "none" : "block";
    });

    window.addEventListener("click", (event) => {
      if (!event.target.closest(".perfil")) {
        perfilMenu.style.display = "none";
      }
    });

    // Cambiar tema claro/oscuro
    themeToggle.addEventListener("click", () => {
      document.body.classList.toggle("dark");
      localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light");
    });

    // Cargar tema guardado
    window.addEventListener("DOMContentLoaded", () => {
      if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
      }
    });
  </script>
</body>
</html>
