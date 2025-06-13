<?php
require_once 'Usuario.php';


if ($usuario) {
    echo "<h2>Información del usuario:</h2>";
    echo "Nombre: " . htmlspecialchars($usuario['nombres']) . "<br>";
    echo "Email: " . htmlspecialchars($usuario['correo']) . "<br>";
} else {
    echo "<p>Usuario no encontrado.</p>";
}

?>
