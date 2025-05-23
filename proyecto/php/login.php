<?php



require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();


    $user = trim($_POST['correo']);
    $contra = trim($_POST['contra']);


    $stmt = $enlace->prepare("SELECT nombres, contraseña FROM admin WHERE correo = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user_data = $result->fetch_assoc(); // Obtiene los datos del usuario como un array asociativo
    $stored_hash = $user_data['contraseña']; // El hash de la contra

    if (password_verify($contra, $stored_hash)) {

        header("location: ../dashboard.html");

    }else{
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
}

?>
