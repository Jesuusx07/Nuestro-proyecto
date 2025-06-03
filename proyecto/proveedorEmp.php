<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenny's - Consultar Proveedores</title> <link rel="stylesheet" href="./css/proveedorEmp.css">
</head>
<body>

    <div class="navbar">
      <div class="navbar-left">
        <a href="index.html"><img src="./img/logo_Favicon.png" alt="Logo Kenny's Favicon"></a>
        <span>EMPLEADO</span>
      </div>

    </div>

    <div class="container">
        <div class="contenido">
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

            <div class="tabla-container">
                <h1 class="titulo">TABLA DE CONSULTA DE PROVEEDORES</h1> <table>
                    <thead>
                        <tr>
                            <th>ID PROVEEDOR</th>
                            <th>RAZÓN SOCIAL / NOMBRE</th>
                            <th>TIPO DE PRODUCTO</th>
                            <th>CONTACTO (Email/Teléfono)</th>
                            <th>DIRECCIÓN</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PROV001</td>
                            <td>Mercado Central S.A.</td>
                            <td>Frutas y Verduras</td>
                            <td>info@mercadocentral.com / 555-1234</td>
                            <td>Calle 10 # 25-30, Bogotá</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>PROV002</td>
                            <td>Cárnicos Premium Ltda.</td>
                            <td>Carnes Rojas y Blancas</td>
                            <td>ventas@carnicospremium.co / 555-5678</td>
                            <td>Av. Principal 123, Medellín</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>PROV003</td>
                            <td>La Gran Fábrica de Pastas</td>
                            <td>Pastas y Cereales</td>
                            <td>pedidos@granfabrica.com / 555-9012</td>
                            <td>Carrera 7 # 8-15, Cali</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>PROV004</td>
                            <td>Sabor Natural Distribuciones</td>
                            <td>Sal, Azúcar y Especias</td>
                            <td>contacto@sabornatural.net / 555-3456</td>
                            <td>Diagonal 45 # 67-89, Barranquilla</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>PROV005</td>
                            <td>Pescados Frescos del Mar</td>
                            <td>Pescados y Mariscos</td>
                            <td>info@pescadosfrescos.com / 555-7890</td>
                            <td>Ruta Costera Km 5, Cartagena</td>
                            <td>Activo</td>
                        </tr>
                         <tr>
                            <td>PROV006</td>
                            <td>Lácteos del Campo S.A.S.</td>
                            <td>Lácteos y Derivados</td>
                            <td>ventas@lacteosdelcampo.com / 555-2345</td>
                            <td>Finca La Esmeralda, Boyacá</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>PROV007</td>
                            <td>Bodega de Vinos Selectos</td>
                            <td>Vinos y Licores</td>
                            <td>pedidos@vinosselectos.com / 555-6789</td>
                            <td>Zona Industrial, Envigado</td>
                            <td>Activo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="botones">
            <button class="btn amarillo">REGISTRAR PROVEEDOR</button> <button class="btn rojo">EDITAR PROVEEDOR</button> </div>
    </div>

</body>
</html>