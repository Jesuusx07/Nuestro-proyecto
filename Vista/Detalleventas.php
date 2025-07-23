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

    if (!$session->isLoggedIn()){
        header("location: login.php");
    }

?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenny's - Consultar </title> <link rel="stylesheet" href="./css/Detalleventa.css">
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
                              <a href="empleado.php" class="sub-btn">Consultar</a>
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
                        <button class="btn-menu">DETALLES DE <br>VENTAS</button>
                        <div class="sub-menu">
                            <a href="Detalleventas.php" class="sub-btn">Consultar</a>
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
                            <a href="inventario.php" class="sub-btn">Consultar</a>
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
$conexion = mysqli_connect("kennys.online", "u112415144_kenny", "Kennys12345", "u112415144_proyecto_kenny");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
        <div class="botones">
            <a class="btn amarillo" href="registerUs.html">REGISTRAR VENTA</a> <button class="btn rojo">EDITAR VENTA</button> </div>
    </div>
<div class="tabla-container">
    <h1 class="titulo">TABLA DE CONSULTA DE DETALLES DE VENTAS</h1> 

<table border="1">
    <tr>
        <th>Venta</th>
        <th>IDVenta</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Fecha</th>
          <th>Total de la venta</th>
       
    </tr>


<?php
$sql = "SELECT * FROM venta_detalle";
$result = mysqli_query($conexion, $sql);

while ($mostrar = mysqli_fetch_array($result)) {
?>
        <tr>
            <td><?php echo $mostrar['id_venta_detalle']; ?></td>
            <td><?php echo $mostrar['id_venta']; ?></td>
            <td><?php echo $mostrar['id_producto']; ?></td>
            <td><?php echo $mostrar['cantidad']; ?></td>
            <td><?php echo $mostrar['precio_unitario_venta']; ?></td>
            <td><?php echo $mostrar['fecha']; ?></td>
          <td><?php echo $mostrar['total_venta']; ?></td>
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