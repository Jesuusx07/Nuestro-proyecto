<?php



require_once 'SessionManager.php';
require_once 'sql.php';

$session = new SessionManager();


    $user = ($_POST['correo']);
    $contra = ($_POST['contra']);


    $stmt = $enlace->prepare("SELECT id_admin, contraseña FROM admin WHERE correo = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result_admin = $stmt->get_result();

    $stmt = $enlace->prepare("SELECT correo, contraseña FROM empleado WHERE correo = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result_empleado = $stmt->get_result();


    if($user == "" || $contra == ""){

        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
    }
    else{
        if ($result_empleado->num_rows === 1 || $result_admin->num_rows === 1) {

            $admin_data = $result_admin->fetch_assoc(); // Obtiene los datos del usuario como un array asociativo
            $stored_hash = $admin_data['contraseña']; // El hash de la contra

            $emple_data = $result_empleado->fetch_assoc(); // Obtiene los datos del usuario como un array asociativo
            $stored_hash_emple = $emple_data['contraseña']; // El hash de la contra
            $email_emple = $emple_data['correo']; 


                    if (password_verify($contra, $stored_hash)) {

                        $session->login(1, $user);
                        header("location: ../dashboard.php");
                        exit;

                    }
                    elseif (password_verify($contra, $stored_hash_emple) && $user == $email_emple){
                        $session->login(2, $user);
                        header("location: ../dashboardEmp.php");
                        exit;
                    }
                    else{
                        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
                        echo "<script type='text/javascript'>";
                        echo "alert('" . $mensaje . "');";
                        echo "window.history.back();"; 
                        echo "</script>";
                        exit; 
                    }
            }
    }



?>
