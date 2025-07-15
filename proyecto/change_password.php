<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/change_password.css">
    <title>Document</title>
</head>
<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <div class="container">
        <form action="php/change_password.php" method="POST">
            <a href="index.html"> <img class="logo" src="img/Logo Principal (1).png" alt="Kenny's Logo"> </a>
            <h1>Recuperacion de su contraseña</h1>
            <h3>Por favor, introduzca su nueva contraseña</h3>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="floatingInput" name="new_contraseña" required> 
                <label for="floatingInput">Introduzca su nueva contraseña</label>
            </div>
            <input type="hidden" name="id_admin" value="<?php echo isset($_GET['id_admin']) ? htmlspecialchars($_GET['id_admin']) : ''; ?>">

            <button class="boton-recuperacion" type="submit">Recuperar Contraseña</button>
        </form>
        </div>
    </main>
</body>
</html>