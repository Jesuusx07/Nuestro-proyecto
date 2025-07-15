<?php
require_once './php/SessionManager.php';
$session = new SessionManager();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar Proveedor</title>
  <link rel="stylesheet" href="./css/registerUs.css">
   <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
</head>
<body>
<header class="navbar">
  

     <span class="logo-text">EMPLEADO</span>
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
    <h2>Registrar Proveedor</h2>
    <div class="regis">
      <form id="formu" action="./php/registerEmpProv.php" method="POST">
        <input type="text" id="nombre" name="fname" placeholder="Nombres">
        <input type="text" id="apelli" name="lname" placeholder="Apellidos">
        <input type="email" id="correo" name="email" placeholder="Correo">
        <input type="password" id="contra" name="password" placeholder="Contraseña">
        <input type="text" id="telefono" name="tele" placeholder="Teléfono">
        <input type="number" id="id" name="documento" placeholder="Documento de identidad">
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
