<?php
class SessionManager {
    // Definimos un tiempo de inactividad por defecto en segundos
    // Por ejemplo:
    // 900 segundos = 15 minutos (15 * 60)
    // 1800 segundos = 30 minutos (30 * 60)
    private $timeout = 300; // Por defecto a 15 minutos

    public function __construct($timeout_override = null) {
        // Si se proporciona un valor de timeout en el constructor, lo usamos.
        // Esto permite crear instancias de SessionManager con diferentes tiempos de inactividad.
        if ($timeout_override !== null) {
            $this->timeout = $timeout_override;
        }

        // Inicia la sesión si aún no ha sido iniciada.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function set($id_error, $valor_error){
        $_SESSION[$id_error] = $valor_error;
    }

        public function has($id_error) {
        return isset($_SESSION[$id_error]);
    }

    public function remove($id_error) {
        unset($_SESSION[$id_error]);
    }

    public function get($id_error) {
        return $_SESSION[$id_error] ?? null;
    }
    

    public function login($userId, $userName) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $userName;
        $_SESSION['last_activity'] = time(); // Registra el momento del login.
    }

    public function isLoggedIn() {
        // Verifica si la variable de sesión 'user_id' existe, lo que indica que hay un usuario logueado.
        return isset($_SESSION['user_id']);
    }

    public function getUserName() {
        // Retorna el nombre de usuario de la sesión, o null si no está seteado.
        return $_SESSION['user_name'] ?? null;
    }

    public function logout() {
        // Desestablece todas las variables de sesión.
        session_unset();
        // Destruye la sesión actual.
        session_destroy();
    }

    // Un método público para que otras partes del código puedan obtener el valor del timeout,
    // útil para la parte de JavaScript que maneja el timeout del lado del cliente.
    public function getTimeoutSeconds() {
        return $this->timeout;
    }
}
?>