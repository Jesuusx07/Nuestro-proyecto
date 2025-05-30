<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olvidar Contraseña</title>
  <style>
    body {
      font-family: "Exo 2", serif;
      background-color: #111;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .contenedor-restablecer {
      background-color: #1c1c1c;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 8px 8px 15px #000, -8px -8px 15px #2a2a2a;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .contenedor-restablecer h2 {
      color: #c0392b;
      margin-bottom: 20px;
    }

    .contenedor-restablecer p {
      font-size: 14px;
      color: #ccc;
      margin-bottom: 20px;
    }

    .campo-correo {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-radius: 10px;
      background-color: #f1f1f1;
      font-size: 16px;
      color: #333;
    }

    .boton-enviar {
      background-color: #A02334;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .boton-enviar:hover {
      background-color: #A02334;
    }

    .enlace-volver {
      color: #ccc;
      font-size: 13px;
      display: block;
      margin-top: 15px;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="contenedor-restablecer">
    <h2>¿Olvidaste tu contraseña?</h2>
    <p>Introduce tu correo electrónico y te enviaremos un enlace para restablecerla.</p>
 <form action="enviar_correo.php" method="POST">
      <input type="email" name="correo" class="campo-correo" placeholder="Correo electrónico" required />
      <button type="submit" class="boton-enviar">Enviar enlace</button>
    </form>
    <a href="login.php" class="enlace-volver">Volver al inicio de sesión</a>
  </div>

</body>
</html>
