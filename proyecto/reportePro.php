<?php
// Primero: Gestión de Sesiones (SEGURIDAD)
require_once './php/SessionManager.php'; // Asegúrate de que la ruta sea correcta desde la ubicación de este archivo

$session = new SessionManager();

// Si el usuario no ha iniciado sesión, redirige a la página de login
if (!$session->isLoggedIn()){
    header("location: login.php");
    exit(); // Siempre usa exit() después de un header(location)
}

// Ahora, incluye tus archivos de base de datos y controlador de usuario
require_once 'sql.php'; // Este archivo ahora contiene solo la clase Database y su método conectar()
require_once 'UsuarioController.php'; // Inclúyelo si lo vas a usar, si no, puedes omitirlo por ahora

// Establece la conexión a la base de datos usando tu clase Database
// $db será tu objeto PDO conectado
$db = (new Database())->conectar();

// No necesitamos el UsuarioController para este reporte de productos específico,
// pero lo dejo aquí por si lo usas en otra parte de esta misma página.
// $controlador = new UsuarioController($db); // Puedes comentar o quitar esta línea si no la usas.

// No necesitas una verificación de conexión tan explícita para PDO después de `conectar()`
// porque el `try-catch` en `conectar()` ya maneja los errores y detiene la ejecución.
// Si el script llega hasta aquí, significa que la conexión fue exitosa.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos</title>
    <style>
        /* Estilos básicos para la tabla y el botón */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e2e6ea;
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: auto;
            border-radius: 4px;
        }
        p {
            color: #555;
            font-style: italic;
        }
    </style>
</head>
<body>

    <h1>Reporte de Productos</h1>

    <form method="post" action="">
        <button type="submit" name="mostrar_productos">Mostrar Productos</button>
    </form>

    <?php
    // Este bloque de PHP se ejecuta solo cuando se envía el formulario (el botón es presionado)
    if (isset($_POST['mostrar_productos'])) {
        $sql = "SELECT id_producto, nombre, categoria, imagen, precio_unitario FROM producto";
        
        try {
            // Prepara la consulta SQL (especialmente útil para consultas con parámetros, pero bueno usarlo)
            $stmt = $db->prepare($sql);
            // Ejecuta la consulta
            $stmt->execute();
            
            // Verifica si se encontraron filas
            if ($stmt->rowCount() > 0) { // Con PDO, usamos rowCount()
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID Producto</th>";
                echo "<th>Nombre</th>";
                echo "<th>Categoría</th>";
                echo "<th>Imagen</th>";
                echo "<th>Precio Unitario</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Recorre cada fila de resultados y las muestra en la tabla
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Con PDO, usamos fetch(PDO::FETCH_ASSOC)
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id_producto"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["categoria"]) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row["imagen"]) . "' alt='Imagen de producto'></td>";
                    echo "<td>" . htmlspecialchars($row["precio_unitario"]) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No se encontraron productos.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al ejecutar la consulta: " . $e->getMessage() . "</p>";
        }
        
        // En PDO, la conexión no necesita ser cerrada explícitamente en cada script
        // a menos que sea una aplicación muy grande con muchas conexiones.
        // PHP cierra automáticamente las conexiones PDO al final del script.
        // $db = null; // Para cerrar explícitamente la conexión si fuera necesario
    }
    ?>

</body>
</html>