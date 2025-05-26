<?php

require_once 'sql.php';

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$tele = $_POST["tele"];
$docu = $_POST["documento"];
$select = $_POST["select"];


if($fname == "" || $lname == "" || $email == "" || $password == "" || $tele == "" || $docu == "" || $select == ""){
        $mensaje = "Credenciales inválidas. Inténtalo de nuevo.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
        exit; 
}
else{
    if($select == "Mesero"){
        $insertar = "INSERT INTO empleado VALUES('', 1, '$fname', '$lname', '$email', '$password', '$tele', '$docu')";
        $ejecutarInsertar = mysqli_query($enlace, $insertar);
        $mensaje = "Registro exitoso.";
        echo "<script type='text/javascript'>";
        echo "alert('" . $mensaje . "');"; 
        echo "window.history.back();"; 
        echo "</script>";
    }


}

?>