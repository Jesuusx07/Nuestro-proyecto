<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenny's - Consultar </title> <link rel="stylesheet" href="./css/consultar.css">
</head>
<body>

    <div class="navbar">
      <div class="navbar-left">
        <a href="index.html"><img src="./img/logo_Favicon.png" alt="Logo Kenny's Favicon"></a>
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
      </div>
    </div>

    <div class="container">
        <div class="contenido">
            <div class="menu-lateral">
                <div class="menu-container">
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>EMPLEADOS</button>
                        <div class="sub-menu">
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>PEDIDO</button>
                        <div class="sub-menu">
                            <a href="pedido.php" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>PRODUCTOS</button>
                        <div class="sub-menu">
                            <a href="producto.php" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>HISTORIAL</button>
                        <div class="sub-menu">
                            <a href="historial.php" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>PROVEEDOR</button>
                        <div class="sub-menu">
                            <a href="proveedores.php" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>RESERVAS</button>
                        <div class="sub-menu">
                            <a href="reservas.php" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br> VENTAS</button>
                        <div class="sub-menu">
                            <a href="ventas.php" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br> INVENTARIO</button>
                        <div class="sub-menu">
                            <a href="inventario.php." class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
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
            </script>

<?php
$conexion = mysqli_connect('localhost', 'root', '', 'proyecto_kenny');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>

<div class="tabla-container">
    <h1 class="titulo">TABLA DE CONSULTA DE EMPLEADO</h1> 

<table border="1">
    <tr>
        <th>Empleado</th>
        <th>Rol</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>correo</th>
        <th>contraseña</th>
        <th>telefono</th>
        <th>documento</th>
    </tr>


<?php
$sql = "SELECT * FROM empleado";
$result = mysqli_query($conexion, $sql);

while ($mostrar = mysqli_fetch_array($result)) {
?>
        <tr>
            <td><?php echo $mostrar['id_empleado']; ?></td>
            <td><?php echo $mostrar['id_rol']; ?></td>
            <td><?php echo $mostrar['nombres']; ?></td>
            <td><?php echo $mostrar['apellidos']; ?></td>
            <td><?php echo $mostrar['correo']; ?></td>
            <td><?php echo $mostrar['contraseña']; ?></td>
            <td><?php echo $mostrar['telefono']; ?></td>
           <td><?php echo $mostrar['documento']; ?></td>
        </tr>
<?php
}
?>
    </table>
</div>

    </table>
</div>


        <div class="botones">
            <a class="btn amarillo" href="registerUs.html">REGISTRAR EMPLEADO</a> <button class="btn rojo">EDITAR EMPLEADO</button> </div>
    </div>

</body>
</html>