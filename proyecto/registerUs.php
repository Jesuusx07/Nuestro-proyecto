<?php


require_once './php/SessionManager.php';

$session = new SessionManager();

?>

<!DOCTYPE html>    
<html lang="es"> 
<head> 
    <title>Registrar usuario</title> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="./css/registerUs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</head> 
<body>

    <div class="navbar">
      <div class="navbar-left">
        <a href="index.html"><img src="./img/logo_Favicon.png" alt=""></a>
        <span>ADMINISTRADOR</span>
      </div>
      <div class="navbar-right">
   
                 </div>
  <div class="perfil">
  <button class="boton-perfil" onclick="toggleMenu()">👤 Perfil</button>
  <div class="menu-desplegable" id="menuPerfil">
    <a href="./php/logout.php">Cerrar sesión</a>
    
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
          </script>

        <div class="form">
            <h2>Registrar Empleados</h2>

            <br>
            <div class="regis">
                <form id="formu" action="./php/registerUs.php" method="POST">
                    <div class="parte1">
                        <label for="fname"></label>
                        <input type="text" id="nombre" name="fname" placeholder="Nombre">
                        <label for="lname"></label>
                        <input type="text" id="apelli" name="lname" placeholder="Apellido">
                    </div>

                    <div class="parte3">
                        <label for="lname"></label>
                        <input type="email" id="correo" name="email" placeholder="Correo">
                    </div>
                    
                    <div class="parte2">
                        <label for="fname"></label>
                        <input type="password" id="contra" name="password" placeholder="Contraseña">
                        <label for="lname"></label>
                        <input type="text" id="telefono" name="tele" placeholder="Telefono">
                    </div>

                    <div class="parte4">
                        <label for="lname"></label>
                        <input type="number" id="id" name="documento" placeholder="Documento de identidad">
                        <select name="select" id="rol">
                            <option value="">Rol</option>
                            <option value="Mesero">Mesero</option>
                            <option value="Cocinero">Cocinero</option>
                            <option value="Limpieza">Limpieza</option>
                        </select>
                    </div>
                    <style>
                      .p-error{
                        color: #A02334;
                        text-align: center;
                        font-size: 20px;    
                      }
                      .exito{
                        
                        color: #96CEB4;
                        text-align: center;
                        font-size: 20px;    
                      }
                    </style>
                    <input type="submit" id="boton" value="Registrar">
                    <?php
                    // Aquí es donde verificas y muestras el mensaje
                        if ($session->has('error_message')) {
                          echo '<div class="error-message">';
                          echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
                          echo '</div>';
                          $session->remove('error_message'); // Borra el mensaje después de mostrarlo
                      }
                        else if ($session->has('exito')) {
                          echo '<div class="exito">';
                          echo '<p>' . htmlspecialchars($session->get('exito')) . '</p>';
                          echo '</div>';
                          $session->remove('exito'); // Borra el mensaje después de mostrarlo
                          $session->remove('error_message'); // Borra el mensaje después de mostrarlo
                      }
                    ?>
                </form> 
            </div>
        </div>
    </div>


</body>