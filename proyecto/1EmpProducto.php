<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenny's - Consultar Productos</title> <link rel="stylesheet" href="./css/productosEmp.css">
</head>
<body>

    <div class="navbar">
      <div class="navbar-left">
        <a href="index.html"><img src="./img/logo_Favicon.png" alt="Logo Kenny's Favicon"></a> 
        <span>EMPLEADO</span>
      </div>
    
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
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>PRODUCTOS</button>
                        <div class="sub-menu">
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>PROVEEDOR</button>
                        <div class="sub-menu">
                            <a href="proveedorEmp.html" class="sub-btn">Consultar</a>
                            <a href="registerUs.html" class="sub-btn">Registrar</a>
                        </div>
                    </div>
        
                    <div class="menu-item">
                        <button class="btn-menu">GESTIÓN DE <br>RESERVAS</button>
                        <div class="sub-menu">
                            <a href="reservasEmp.php" class="sub-btn">Consultar</a>
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

            <div class="tabla-container">
                <h1 class="titulo">TABLA DE CONSULTA DE PRODUCTOS</h1> <table>
                    <thead>
                        <tr>
                            <th>ID PRODUCTO</th>
                            <th>NOMBRE</th>
                            <th>CATEGORÍA</th>
                            <th>CANTIDAD (kg/unid)</th>
                            <th>PRECIO UNITARIO</th>
                            <th>PROVEEDOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PRD001</td>
                            <td>Tomates Chonto</td>
                            <td>Verduras</td>
                            <td>10 kg</td>
                            <td>$3.500</td>
                            <td>Mercado Central</td>
                        </tr>
                        <tr>
                            <td>PRD002</td>
                            <td>Plátano Maduro</td>
                            <td>Frutas</td>
                            <td>15 unid</td>
                            <td>$1.200</td>
                            <td>Frutas Frescas S.A.</td>
                        </tr>
                        <tr>
                            <td>PRD003</td>
                            <td>Carne de Res (Lomo)</td>
                            <td>Carnes</td>
                            <td>5 kg</td>
                            <td>$35.000</td>
                            <td>Cárnicos Premium</td>
                        </tr>
                        <tr>
                            <td>PRD004</td>
                            <td>Pasta Penne</td>
                            <td>Pastas</td>
                            <td>8 kg</td>
                            <td>$6.800</td>
                            <td>La Gran Fábrica</td>
                        </tr>
                        <tr>
                            <td>PRD005</td>
                            <td>Sal Marina (Gruesa)</td>
                            <td>Condimentos</td>
                            <td>2 kg</td>
                            <td>$2.500</td>
                            <td>Sabor Natural</td>
                        </tr>
                        <tr>
                            <td>PRD006</td>
                            <td>Azúcar Blanca</td>
                            <td>Condimentos</td>
                            <td>3 kg</td>
                            <td>$4.000</td>
                            <td>Dulce Cosecha</td>
                        </tr>
                         <tr>
                            <td>PRD007</td>
                            <td>Lechuga Romana</td>
                            <td>Verduras</td>
                            <td>7 unid</td>
                            <td>$2.000</td>
                            <td>Huerta Orgánica</td>
                        </tr>
                        <tr>
                            <td>PRD008</td>
                            <td>Pechuga de Pollo</td>
                            <td>Carnes</td>
                            <td>12 kg</td>
                            <td>$18.000</td>
                            <td>Avícola Sana</td>
                        </tr>
                        <tr>
                            <td>PRD009</td>
                            <td>Espagueti Integral</td>
                            <td>Pastas</td>
                            <td>6 kg</td>
                            <td>$7.500</td>
                            <td>Alimentaria S.A.S.</td>
                        </tr>
                        <tr>
                            <td>PRD010</td>
                            <td>Pimientos Rojos</td>
                            <td>Verduras</td>
                            <td>4 kg</td>
                            <td>$4.800</td>
                            <td>Finca el Sol</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="botones">
            <button class="btn amarillo">REGISTRAR PRODUCTO</button> <button class="btn rojo">EDITAR PRODUCTO</button> </div>
    </div>

</body>
</html>