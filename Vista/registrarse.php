<?php


require_once '../config/SessionManager.php';

$session = new SessionManager();

if (!$session->isLoggedIn()) {
} else {
    if ($_SESSION['user_id'] == 1) {
        header("location: dashboard.php");
    } else {
        header("location: dashboardEmp.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="./css/registrarse.css" />
  <title>Registrarse en Kennys</title>
</head>
<body>

  <div class="container">
    <img src="./img/Logo Principal (1).png" class="logo" alt="icono" />
    <h2>Crear una cuenta</h2>
    <p>Es rápido y fácil.</p>
    <form action="../Rutas/register.php" method="post">
      <div class="name-fields">
        <input type="text" placeholder="Nombres" name="nombre" required />
        <input type="text" placeholder="Apellidos" name="apellido" required />
      </div>

      <input type="email" placeholder="Correo electrónico" name="email" required />

      <!-- Campo contraseña 1 -->
      <div class="password-wrapper">
        <input type="password" placeholder="Nueva contraseña" name="pass" id="pass1" required />
        <button type="button" class="toggle-password" aria-label="Mostrar contraseña">👁️</button>
      </div>
      <div class="name-fields">
        <input type="text" placeholder="Telefono" name="telefono" required />
        <input type="text" placeholder="Documento" name="documento" required />
      </div>

      <?php
      // Aquí es donde verificas y muestras el mensaje
        if ($session->has('error_message')) {
        echo '<div class="error-message">';
        echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
        echo '</div>';
        $session->remove('error_message'); // Borra el mensaje después de mostrarlo
      }
      ?>
      <style>
          .p-error{
              color: #A02334;
              text-align: center;
          }
      </style>

      <button type="submit" class="btn-submit">Registrarte</button>

      <a class="btn-submit2" href="login.php">¿Ya tienes una cuenta?</a>

      <div class="terms">
        Al hacer clic en "Registrarte", aceptas nuestras Condiciones, la Política de privacidad y la Política de cookies.
      </div>
    </form>
  </div>

  <script>
    // Seleccionamos todos los botones toggle-password
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');

    togglePasswordButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Encontrar el input asociado (hermano anterior)
        const passwordInput = button.previousElementSibling;
        const isPassword = passwordInput.getAttribute('type') === 'password';

        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        // Aquí decides si cambias el icono o no. Para mantenerlo igual, comentar la siguiente línea:
        // button.textContent = isPassword ? '🙈' : '👁️';
      });
    });
  </script>

</body>
</html>
