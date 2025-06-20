<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenny's - Consultar Producto</title>
    <link rel="stylesheet" href="./css/producto.css">
</head>
<body>

  <div class="navbar">
    <div class="navbar-left">
       <img src="./img/Logo Principal 2.png" alt="Logo Kenny's" class="logo-navbar" />
  
      <a href="index.html"> <img src="./img/logo_Favicon.png" alt="Logo Kenny's"></a>
      <span>ADMINISTRADOR</span>
    </div>
    <div class="perfil">
      <button class="boton-perfil" onclick="toggleMenu()"><i class="fas fa-user"></i> Perfil</button>
      <div class="menu-desplegable" id="menuPerfil">
        <a href="./php/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
      </div>
    </div>
  </div>
        

    <div class="container">
        <div class="contenido">
            <div class="menu-lateral">
                <div class="menu-container">
                     <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>EMPLEADO</button>
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
                            <a href="inventario.php." class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $conexion = mysqli_connect('localhost', 'root', '', 'proyecto_kenny');

            if (!$conexion) {
                die("Error de conexión: " . mysqli_connect_error());
            }
            ?>
    <div class="botones">
                <a class="btn amarillo" href="registrarProducto.php">REGISTRAR PRODUCTO</a>
                <button class="btn rojo">EDITAR PRODUCTO</button>
            </div>
            <div class="tabla-container">
                <h1 class="titulo">TABLA DE CONSULTA DE PRODUCTO</h1>

                <table border="1">
                    <tr>
                        <th>Producto</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>

                    <?php
                    $sql = "SELECT * FROM producto";
                    $result = mysqli_query($conexion, $sql);

                    while ($mostrar = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $mostrar['id_producto']; ?></td>
                            <td><?php echo $mostrar['nombre']; ?></td>
                            <td><?php echo $mostrar['categoria']; ?></td>
                 
                            <td><?php echo $mostrar['cantidad_en_stock']; ?></td>
                            <td><?php echo $mostrar['precio_unitario']; ?></td>
                        </tr>
                    <?php
                    }
                    mysqli_close($conexion); // Close the database connection
                    ?>
                </table>
            </div>


        </div>
    </div>

    <script>
        // Script for the profile dropdown menu
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

        // Script for the side menu items with sub-menus
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

</body>
</html>