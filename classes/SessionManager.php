<?php
require_once 'Usuario.php';
require_once 'Perfil.php';

class SessionManager {
    private static $instance = null;
    private $usuario = null;
    private $db;

    private function __construct($db) {
        $this->db = $db;
        $this->inicializarSesion();
    }

    public static function getInstance($db) {
        if (self::$instance === null) {
            self::$instance = new self($db);
        }
        return self::$instance;
    }

    private function inicializarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Regenerar ID de sesión periódicamente para seguridad
        if (!isset($_SESSION['regenerated'])) {
            session_regenerate_id(true);
            $_SESSION['regenerated'] = time();
        }
        
        if (isset($_SESSION['username']) && isset($_SESSION['userID'])) {
            $this->usuario = Usuario::fromSession($this->db);
        }
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function isLoggedIn() {
        return $this->usuario !== null && isset($_SESSION['username']);
    }

    /**
     * Iniciar sesión con username y password
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña
     * @return bool True si el login fue exitoso, false en caso contrario
     */
    public function login($username, $password) {
        // Preparar consulta para evitar SQL injection
        $stmt = $this->db->prepare("SELECT id, username, password_hash, Rol_ID, area_usuario_id FROM usuario WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Verificar contraseña
            if (password_verify($password, $row['password_hash'])) {
                // Regenerar ID de sesión después del login exitoso
                session_regenerate_id(true);
                
                // Establecer variables de sesión
                $_SESSION['username'] = $username;
                $_SESSION['rolID'] = $row['Rol_ID'];
                $_SESSION['userID'] = $row['id'];
                $_SESSION['area_usuario_id'] = $row['area_usuario_id'];
                $_SESSION['login_time'] = time();
                $_SESSION['last_activity'] = time();
                
                // Cargar objeto usuario
                $this->usuario = Usuario::fromSession($this->db);
                
                // Log del login exitoso (opcional)
                $this->logActivity("Login exitoso para usuario: " . $username);
                
                return true;
            } else {
                // Log de intento de login fallido (opcional)
                $this->logActivity("Intento de login fallido para usuario: " . $username);
            }
        } else {
            // Log de intento con usuario inexistente (opcional)
            $this->logActivity("Intento de login con usuario inexistente: " . $username);
        }
        
        return false;
    }

    /**
     * Cerrar sesión del usuario actual
     * @return void
     */
    public function logout() {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'desconocido';
        
        // Log del logout (opcional)
        $this->logActivity("Logout para usuario: " . $username);
        
        // Limpiar variables de sesión
        $_SESSION = array();
        
        // Destruir la cookie de sesión si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destruir la sesión
        session_destroy();
        $this->usuario = null;
    }

    /**
     * Requiere que el usuario haya iniciado sesión
     * Redirige a la página de login si no ha iniciado sesión
     * @return void 
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header("Location: ../index.php?mensaje=Debe iniciar sesión para acceder");
            exit();
        }
        
        // Verificar timeout de sesión (opcional: 8 horas)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 28800)) {
            $this->logout();
            header("Location: ../index.php?mensaje=Su sesión ha expirado");
            exit();
        }
        
        // Actualizar última actividad
        $_SESSION['last_activity'] = time();
    }

    /**
     * Requiere que el usuario tenga uno de los roles especificados
     * @param array|int $roles Un solo rol o un array de roles permitidos
     * @return void Redirige si no tiene el rol adecuado
     */
    public function requireRole($roles) {
        $this->requireLogin();
        
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        
        if (!in_array($this->usuario->getRolID(), $roles)) {
            $this->logActivity("Acceso denegado para usuario: " . $this->usuario->getUsername() . " - Rol: " . $this->usuario->getRolID());
            header("Location: ../index.php?mensaje=No tiene permisos para acceder a esta página");
            exit();
        }
    }

    /**
     * Verficar si el usuario tiene un permiso específico
     * @param string $permission Nombre del permiso a verificar (ej. 'admin', 'jefe', 'rh', 'personal')
     * @return bool True si tiene el permiso, false en caso contrario
     */
    public function checkPermission($permission) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        // Aquí puedes implementar un sistema de permisos más granular
        // Por ejemplo, consultando una tabla de permisos por rol
        switch ($permission) {
            case 'admin':
                return $this->usuario->esAdmin();
            case 'jefe':
                return $this->usuario->esJefe();
            case 'rh':
                return $this->usuario->esRecursosHumanos();
            case 'personal':
                return $this->usuario->esPersonal();
            default:
                return false;
        }
    }

    private function logActivity($message) {
        // Opcional: implementar logging de actividades
        error_log(date('Y-m-d H:i:s') . " - " . $message);
        
        // O guardar en base de datos
        /*
        $stmt = $this->db->prepare("INSERT INTO log_actividad (fecha, mensaje, ip) VALUES (NOW(), ?, ?)");
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
        $stmt->bind_param("ss", $message, $ip);
        $stmt->execute();
        */
    }

    public function getSessionInfo() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        return [
            'username' => $_SESSION['username'],
            'rolID' => $_SESSION['rolID'],
            'userID' => $_SESSION['userID'],
            'login_time' => $_SESSION['login_time'] ?? null,
            'last_activity' => $_SESSION['last_activity'] ?? null,
            'session_duration' => isset($_SESSION['login_time']) ? (time() - $_SESSION['login_time']) : 0
        ];
    }
}
?>