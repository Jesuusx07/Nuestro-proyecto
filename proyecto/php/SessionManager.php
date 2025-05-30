<?php
class SessionManager {
    private $timeout = 9999999999; // Tiempo de expiración en segundos (15 min)

    public function __construct($timeout = 99999999999) {
        $this->timeout = $timeout;
        session_start();
        $this->checkSessionTimeout();
    }

    public function login($userId, $userName) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $userName;
        $_SESSION['last_activity'] = time();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUserName() {
        return $_SESSION['user_name'] ?? null;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    private function checkSessionTimeout() {
        if (isset($_SESSION['last_activity'])) {
            if (time() - $_SESSION['last_activity'] > $this->timeout) {
                $this->logout();
                $mensaje = "Sesion cerrada por inactividad.";
                echo "<script type='text/javascript'>";
                echo "alert('" . $mensaje . "');"; 
                echo "window.location.href = 'login.php'"; 
                echo "</script>";
                exit;
            } else {
                $_SESSION['last_activity'] = time(); // Renueva la actividad
            }
        }
    }
}
?>
