<?php
require_once './php/SessionManager.php';
$session = new SessionManager();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar Producto</title>
  <link rel="stylesheet" href="./css/registerUs.css">
   <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
</head>
<body>
<header class="navbar">
  

        <a href="dashboardEmp.php" class="logo-text">EMPLEADO</a>
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
    <h2>Registrar Producto</h2>
    <div class="regis">
      <form id="formu" action="./php/registerEmpPro.php" method="POST">
        <input type="text" id="nombre" name="nombre" placeholder="Nombre">
        <select name="select" id="cat">
          <option value="">Categoria</option>
        <option value="Fruta">Fruta</option>
<option value="Vegetal">Vegetal</option>
<option value="Salsa">Salsa</option>
<option value="Carne">Carne</option>
<option value="Pollo">Pollo</option>
<option value="Pescado y Mariscos">Pescado y Mariscos</option>
<option value="Cereal y Harinas">Cereal y Harinas</option>
<option value="Lácteo">Lácteo</option>
<option value="Bebida">Bebida</option>
<option value="Postre">Postre</option>
<option value="Panadería">Panadería</option>
<option value="Aceites y Grasas">Aceites y Grasas</option>
<option value="Especias y Condimentos">Especias y Condimentos</option>
<option value="Congelados">Congelados</option>
<option value="Enlatados">Enlatados</option>
<option value="Limpieza">Limpieza</option>
<option value="Desechables">Desechables</option>
<option value="Otros">Otros</option>
        </select>
        <input type="file" id="imagen" name="imagen" accept="image/*">
        <input type="number" id="precio" name="precio" placeholder="Precio" step="0.01" min="0">

          <select name="proveedor" id="usuario">
                <option value="">Proveedor</option>
          <?php

          $conexion = mysqli_connect("localhost", "root", "", "proyecto_kenny");
          $sql = "SELECT * FROM usuario where id_rol = 'proveedor'";
          $result = mysqli_query($conexion, $sql);

          
          while ($mostrar = mysqli_fetch_array($result)) {
          ?>

                <option value= <?php echo $mostrar['correo']?>> <?php echo htmlspecialchars($mostrar['nombres']); ?></option>

          <?php
          }
          ?>
          </select>

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
