<?php
class SessionManager {
    // Definimos un tiempo de inactividad por defecto en segundos
    // Por ejemplo:
    // 900 segundos = 15 minutos (15 * 60)
    // 1800 segundos = 30 minutos (30 * 60)
    private $timeout = 1; // Por defecto a 15 minutos

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

        // Llama a la función para verificar el timeout de la sesión.
        $this->checkSessionTimeout();
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

    private function checkSessionTimeout() {
        // Solo verificamos el timeout si hay un usuario logueado y tenemos el registro de su última actividad.
        if ($this->isLoggedIn() && isset($_SESSION['last_activity'])) {
            // Calcula el tiempo transcurrido desde la última actividad.
            $elapsed_time = time() - $_SESSION['last_activity'];

            // Si el tiempo transcurrido es mayor que el timeout definido, la sesión ha expirado.
            if ($elapsed_time > $this->timeout) {
                $this->logout(); // Cierra la sesión.

                // Muestra una alerta y redirige al usuario a la página de login.
                // Es crucial que esta salida se realice antes de cualquier HTML para evitar errores de "headers already sent".
                echo "<script type='text/javascript'>";
                echo "alert('Su sesión ha caducado por inactividad. Por favor, inicie sesión de nuevo.');";
                echo "window.location.href = 'login.php';"; // Redirige a la página de login.
                echo "</script>";
                exit(); // Detiene la ejecución del script PHP para asegurar la redirección.
            } else {
                // Si la sesión no ha expirado, actualiza el tiempo de la última actividad para extender la sesión.
                $_SESSION['last_activity'] = time();
            }
        }
    }

    // Un método público para que otras partes del código puedan obtener el valor del timeout,
    // útil para la parte de JavaScript que maneja el timeout del lado del cliente.
    public function getTimeoutSeconds() {
        return $this->timeout;
    }
}
?>