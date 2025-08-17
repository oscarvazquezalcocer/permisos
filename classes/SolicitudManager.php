<?php
class SolicitudManager {
    private $db;
    private $usuario;

    public function __construct($db, $usuario) {
        $this->db = $db;
        $this->usuario = $usuario;
    }

    /**
     * Obtiene las solicitudes activas, excluyendo ciertos estados.
     * @param array $disabledStates Estados a excluir (por ejemplo, [32, 33])
     * @return mysqli_result Resultado de la consulta con las solicitudes activas
     */
    public function obtenerSolicitudesActivasExcepto($disabledStates) {
        $placeholders = implode(',', array_fill(0, count($disabledStates), '?'));
        $types = str_repeat('i', count($disabledStates));
        $params = $disabledStates;

        $query = "
            SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, perfil.nombre, perfil.puesto, solicitud.Request_at, solicitud.motivo
            FROM solicitud
            JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
            JOIN perfil ON solicitud.User_ID = perfil.User_ID
            WHERE solicitud.Estado_ID NOT IN ($placeholders)
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtenerNotificaciones() {
        $notificaciones = [];
        
        // Solicitudes aceptadas
        $stmt = $this->db->prepare("
            SELECT sueldo, ID, modified_by, notificacion 
            FROM solicitud 
            WHERE Estado_ID = 32 AND notificacion = 0 AND User_ID = ? 
            LIMIT 1
        ");
        $stmt->bind_param("i", $this->usuario->getId());
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $notificaciones[] = [
                'tipo' => 'aceptada',
                'id' => $row['ID'],
                'sueldo' => $row['sueldo'],
                'modified_by' => $row['modified_by']
            ];
        }

        // Solicitudes rechazadas
        $stmt = $this->db->prepare("
            SELECT mensaje, ID, modified_by, notificacion 
            FROM solicitud 
            WHERE Estado_ID = 33 AND notificacion = 0 AND User_ID = ? 
            LIMIT 1
        ");
        $stmt->bind_param("i", $this->usuario->getId());
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $notificaciones[] = [
                'tipo' => 'rechazada',
                'id' => $row['ID'],
                'mensaje' => $row['mensaje'],
                'modified_by' => $row['modified_by']
            ];
        }

        return $notificaciones;
    }
}
?>