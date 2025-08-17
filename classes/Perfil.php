<?php
class Perfil {
    private $id;
    private $nombre;
    private $apellido;
    private $sexo;
    private $area;
    private $puesto;
    private $createAt;
    private $updateAt;
    private $userID;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function cargarPorUsuarioId($userID) {
        $stmt = $this->db->prepare("SELECT * FROM perfil WHERE User_ID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->sexo = $row['sexo'];
            $this->area = $row['area'];
            $this->puesto = $row['puesto'];
            $this->createAt = $row['create_at'];
            $this->updateAt = $row['update_at'];
            $this->userID = $row['User_ID'];
            return true;
        }
        return false;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getApellido() { return $this->apellido; }
    public function getSexo() { return $this->sexo; }
    public function getArea() { return $this->area; }
    public function getPuesto() { return $this->puesto; }
    public function getCreateAt() { return $this->createAt; }
    public function getUpdateAt() { return $this->updateAt; }
    public function getUserID() { return $this->userID; }

    public function getNombreCompleto() {
        return trim($this->nombre . ' ' . $this->apellido);
    }

    // Setters para actualizar perfil
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellido($apellido) { $this->apellido = $apellido; }
    public function setSexo($sexo) { $this->sexo = $sexo; }
    public function setArea($area) { $this->area = $area; }
    public function setPuesto($puesto) { $this->puesto = $puesto; }

    public function actualizar() {
        $stmt = $this->db->prepare("UPDATE perfil SET nombre = ?, apellido = ?, sexo = ?, area = ?, puesto = ?, update_at = CURRENT_TIMESTAMP WHERE User_ID = ?");
        $stmt->bind_param("sssssi", $this->nombre, $this->apellido, $this->sexo, $this->area, $this->puesto, $this->userID);
        return $stmt->execute();
    }
}
?>