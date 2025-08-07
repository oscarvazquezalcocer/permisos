<?php
/**
 * Clase Usuario
 * Maneja la información del usuario y su perfil.
 * Permite cargar datos desde la sesión o por username/ID.
 */
class Usuario {
    private $id;
    private $username;
    private $email;
    private $rolID;
    private $tipoUsuarioID;
    private $areaUsuarioID;
    private $createAt;
    private $updateAt;
    private $perfil;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->perfil = null;
    }

    // Cargar usuario desde la sesión
    /**
     * Cargar usuario desde la sesión
     * @return Usuario|null Retorna una instancia de Usuario o null si no hay usuario en sesión
     */
    public static function fromSession($db) {
        if (!isset($_SESSION['username'])) {
            return null;
        }
        
        $usuario = new self($db);
        if ($usuario->cargarPorUsername($_SESSION['username'])) {
            return $usuario;
        }
        return null;
    }

    // Cargar usuario por username
    public function cargarPorUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $this->mapearDatos($row);
            $this->cargarPerfil();
            return true;
        }
        return false;
    }

    // Cargar usuario por ID
    public function cargarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $this->mapearDatos($row);
            $this->cargarPerfil();
            return true;
        }
        return false;
    }

    private function mapearDatos($row) {
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->rolID = $row['Rol_ID'];
        $this->tipoUsuarioID = $row['Tipo_usuario_ID'];
        $this->areaUsuarioID = $row['area_usuario_id'];
        $this->createAt = $row['create_at'];
        $this->updateAt = $row['update_at'];
    }

    private function cargarPerfil() {
        $this->perfil = new Perfil($this->db);
        $this->perfil->cargarPorUsuarioId($this->id);
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getRolID() { return $this->rolID; }
    public function getTipoUsuarioID() { return $this->tipoUsuarioID; }
    public function getAreaUsuarioID() { return $this->areaUsuarioID; }
    public function getCreateAt() { return $this->createAt; }
    public function getUpdateAt() { return $this->updateAt; }
    public function getPerfil() { return $this->perfil; }

    // Métodos útiles
    public function getNombreCompleto() {
        return $this->perfil ? $this->perfil->getNombreCompleto() : '';
    }

    public function getRolNombre() {
        $stmt = $this->db->prepare("SELECT Rol_nombre FROM rol WHERE ID = ?");
        $stmt->bind_param("i", $this->rolID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['Rol_nombre'] : '';
    }

    public function getAreaUsuarioNombre() {
        $stmt = $this->db->prepare("SELECT area_usuario_nombre FROM area_usuario WHERE ID = ?");
        $stmt->bind_param("i", $this->areaUsuarioID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['area_usuario_nombre'] : '';
    }

    public function esAdmin() {
        return $this->rolID == 23;
    }

    public function esJefe() {
        return $this->rolID == 22;
    }

    public function esRecursosHumanos() {
        return $this->rolID == 24;
    }

    public function esPersonal() {
        return $this->rolID == 21;
    }

    public function estaInactivo() {
        return $this->rolID == 25;
    }
}
?>