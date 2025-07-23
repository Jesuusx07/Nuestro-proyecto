<?php

require_once './php/SessionManager.php';

$session = new SessionManager();

    if (!$session->isLoggedIn()){
        header("location: login.php");
        exit();
    }

?>
<?php

require_once './php/SessionManager.php';
require_once './php/sql.php'; // Asumiendo que este archivo contiene la clase Database con conexión PDO

$session = new SessionManager();

// Conectar a la base de datos usando la clase Database
try {
    $db = (new Database())->conectar();
} catch (PDOException $e) {
    // Manejo de errores si la conexión falla
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Inicializar variables para los campos del formulario
// Usamos el operador null coalescing (?? '') para evitar advertencias si una variable no está definida
$id_pla = $_GET['id_pla'] ?? '';
$nombre = $_GET['nombre'] ?? '';
$descripcion = $_GET['descripcion'] ?? '';
$precio = $_GET['precio'] ?? '';
$pla_categoria = $_GET['pla_categoria'] ?? '';

// Nota: 'imagen' ya no es una columna en la tabla platillo, así que no se recupera ni se usa aquí.

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Platillo - Kenny's Restaurante</title>
    <!-- Revisa si este CSS es adecuado para tu diseño de platillos o si necesitas uno nuevo -->
    <link rel="stylesheet" href="./css/editarEmpleado.css">
</head>
<body>

    <div class="container">
        <h2>Editar Platillo</h2>
        <!-- El formulario enviará los datos al script PHP que procesará la actualización del platillo -->
        <form action="./php/editarPlatillo.php" method="POST">
            <div class="form-group">
                <!-- Campo oculto para enviar el ID del platillo a editar -->
                <input type="hidden" name="id_pla" value="<?php echo htmlspecialchars($id_pla); ?>">
                <!-- No hay campo oculto para imagen1, ya que no hay imágenes en la tabla platillo -->

                <label for="nombre">Nombre</label>
                <!-- trim() para eliminar espacios en blanco al inicio/final del nombre -->
                <input type="text" id="nombre" name="nombre" value="<?php echo trim(htmlspecialchars($nombre)); ?>" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <!-- Campo de texto para la descripción -->
                <textarea id="descripcion" name="descripcion" rows="4" required><?php echo htmlspecialchars($descripcion); ?></textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <!-- Tipo "number" para el precio, con paso 0.01 para decimales -->
                <input type="number" id="precio" name="precio" step="0.01" min="0" value="<?php echo htmlspecialchars($precio); ?>" required>
            </div>

            <div class="form-group">
                <label for="pla_categoria">Categoría</label>
                <!-- Menú desplegable para la categoría del platillo -->
                <select name="pla_categoria" id="pla_categoria" required>
                    <!-- Las opciones se generan dinámicamente y se selecciona la actual -->
                    <option value="">Selecciona una Categoría</option>
                    <option value="Entrada" <?php echo ($pla_categoria == 'Entrada') ? 'selected' : ''; ?>>Entrada</option>
                    <option value="Plato Fuerte" <?php echo ($pla_categoria == 'Plato Fuerte') ? 'selected' : ''; ?>>Plato Fuerte</option>
                    <option value="Postre" <?php echo ($pla_categoria == 'Postre') ? 'selected' : ''; ?>>Postre</option>
                    <option value="Bebida" <?php echo ($pla_categoria == 'Bebida') ? 'selected' : ''; ?>>Bebida</option>
                    <option value="Ensaladas" <?php echo ($pla_categoria == 'Ensaladas') ? 'selected' : ''; ?>>Ensaladas</option>
                    <option value="Sopas" <?php echo ($pla_categoria == 'Sopas') ? 'selected' : ''; ?>>Sopas</option>
                    <option value="Desayuno" <?php echo ($pla_categoria == 'Desayuno') ? 'selected' : ''; ?>>Desayuno</option>
                </select>
            </div>

            <!-- Estilos para mensajes de error, si los hay -->
            <style>
                .p-error{
                    color: #A02334;
                    text-align: center;
                    font-size: 20px;
                }
            </style>
            <?php
            // Aquí es donde verificas y muestras el mensaje de error de la sesión
            if ($session->has('error_message')) {
                echo '<div class="error-message">';
                echo '<p class="p-error">' . htmlspecialchars($session->get('error_message')) . '</p>';
                echo '</div>';
                $session->remove('error_message'); // Borra el mensaje después de mostrarlo
            }
            ?>
            <button type="submit" class="btn">Editar Platillo</button>
        </form>
    </div>

</body>
</html>