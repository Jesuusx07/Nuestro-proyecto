<!DOCTYPE html>
<html lang="es">
<head><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kenny's – Consultar</title>
  <!-- Hoja de estilos principal -->
  <link rel="stylesheet" href="./css/CSSdeConsultar.css" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --color-primary: #a02334;
      --color-bg-light: #f4f4f4;
      --color-bg-secondary-light: #ffffff;
      --color-text-light: #1c1c1c;

      --color-bg-dark: #181818;
      --color-bg-secondary-dark: #242424;
      --color-text-dark: #f1f1f1;
    }

    body {
      font-family: "Exo 2", sans-serif;
      margin: 0;
      transition: background 0.3s, color 0.3s;
    }

    body.light-theme {
      background: var(--color-bg-light);
      color: var(--color-text-light);
    }

    body.dark-theme {
      background: var(--color-bg-dark);
      color: var(--color-text-dark);
    }

    .navbar {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 28px;
      background-color: #1c1c1c;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-text {
      font-size: 22px;
      font-weight: bold;
      color: var(--color-primary);
    }

    .navbar-right {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    #themeToggle {
      background: transparent;
      border: none;
      font-size: 20px;
      cursor: pointer;
      color: white;
    }

    .boton-perfil {
      background-color: var(--color-primary);
      color: #fff;
      padding: 8px 12px;
      border: none;
      border-radius: 50%;
      cursor: pointer;
    }

    .menu-desplegable {
      display: none;
      position: absolute;
      top: 48px;
      right: 0;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      min-width: 160px;
      z-index: 1000;
    }

    body.dark-theme .menu-desplegable {
      background: var(--color-bg-secondary-dark);
    }

    .menu-desplegable.open {
      display: block;
    }

    .menu-desplegable a {
      display: block;
      padding: 10px 16px;
      color: inherit;
      text-decoration: none;
    }

    .menu-desplegable a:hover {
      background: rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body class="light-theme">
  <header class="navbar">
    <div class="navbar-left">

      <span class="logo-text">ADMINISTRADOR</span>
    </div>
    <div class="navbar-right">
      <button id="themeToggle" title="Cambiar tema claro/oscuro">🌓</button>
      <div class="perfil" style="position:relative;">
        <button class="boton-perfil" id="perfilBtn">👤</button>
        <div class="menu-desplegable" id="perfilMenu">

          <a href="#">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="contenido">
      <div class="menu-lateral">
        <div class="menu-container">
          <!-- aquí tu menú -->
        </div>
      </div>

      <?php
      $conexion = mysqli_connect('localhost', 'root', '', 'proyecto_kenny');
      if (!$conexion) {
          die("Error de conexión: " . mysqli_connect_error());
      }
      ?>

      <div class="botones">
        <a class="btn amarillo" href="registrarProducto.php">REGISTRAR PROVEEDOR</a>
     
      </div>

      <div class="tabla-container">
        <h1 class="titulo">TABLA DE CONSULTA DE PROVEEDOR</h1>
        <table>
          <tr>
            <th>IDProveedor</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
          <?php
          $sql = "SELECT * FROM usuario WHERE id_rol != 'admin'";
          $result = mysqli_query($conexion, $sql);

          while ($mostrar = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$mostrar['id_empleado']}</td>";
            echo "<td>{$mostrar['id_rol']}</td>";
            echo "<td>{$mostrar['nombres']}</td>";
            echo "<td>{$mostrar['apellidos']}</td>";
            echo "<td>{$mostrar['correo']}</td>";
            echo "<td>{$mostrar['contraseña']}</td>";
            echo "<td>{$mostrar['telefono']}</td>";
            echo "<td>{$mostrar['documento']}</td>";
            echo "<td><a href='editar_empleado.php?id={$mostrar['id_empleado']}&id_rol={$mostrar['id_rol']}&nom={$mostrar['nombres']}&apell={$mostrar['apellidos']}&email={$mostrar['correo']}&tel={$mostrar['telefono']}&docu={$mostrar['documento']}' class='boton-edi'>Editar</a></td>";
            echo "<td><a href='./php/eliminarEmp.php?id={$mostrar['id_empleado']}' class='boton' onclick=\"return confirm('¿Estás seguro de que quieres eliminar este empleado?');\">Eliminar</a></td>";
            echo "</tr>";
          }
          ?>
        </table>
      </div>
    </div>
  </div>

  <script>
    const body = document.body;
    const themeToggle = document.getElementById('themeToggle');

    themeToggle.addEventListener('click', () => {
      if (body.classList.contains('dark-theme')) {
        body.classList.replace('dark-theme', 'light-theme');
      } else {
        body.classList.replace('light-theme', 'dark-theme');
      }
    });

    const perfilBtn = document.getElementById('perfilBtn');
    const perfilMenu = document.getElementById('perfilMenu');

    perfilBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      perfilMenu.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
      if (!perfilBtn.contains(e.target) && !perfilMenu.contains(e.target)) {
        perfilMenu.classList.remove('open');
      }
    });
  </script>
</body>
</html>
