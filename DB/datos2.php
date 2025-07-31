<?php
include_once 'Db.php';

// Verifica si se proporcionó un ID de solicitud en el URL
if (isset($_GET['id'])) {
    $solicitudID = $_GET['id'];

    // Realiza la consulta para obtener los datos de la solicitud específica
    $query = "SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, perfil.nombre, perfil.apellido, perfil.puesto, perfil.area,
            solicitud.Request_at, solicitud.de_fecha, solicitud.a_fecha, solicitud.reposicion, solicitud.fecha_r1, solicitud.fecha_r2,
            solicitud.sueldo, solicitud.hora_establecida, solicitud.hora_modificada, solicitud.motivo, solicitud.otro, solicitud.adjunto, estado.Estado_nombre
            FROM solicitud
            JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
            JOIN perfil ON solicitud.User_ID = perfil.User_ID
            JOIN estado ON solicitud.Estado_ID = estado.ID
            WHERE solicitud.ID = $solicitudID";

    $result = $MySQLiconn->query($query);

    // Verifica si hay resultados
    if ($result) {
        // Verifica si se encontraron solicitudes en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tipoSolicitudNombre = $row['Tipo_solicitud_nombre'];
                $nombre = $row['nombre'];
                $apellido = $row['apellido'];
                $puesto = $row['puesto'];
                $area = $row['area'];
                $requestAt = $row['Request_at'];
                $deFecha = $row['de_fecha'];
                $aFecha = $row['a_fecha'];
                $reposicion = $row['reposicion'];
                $fechaR1 = $row['fecha_r1'];
                $fechaR2 = $row['fecha_r2'];
                $gsueldo = $row['sueldo'];
                $horaEstablecida = $row['hora_establecida'];
                $horaModificada = $row['hora_modificada'];
                $motivo = $row['motivo'];
                $otro = $row['otro'];
                $adjunto = $row['adjunto'];
                $estadoNombre = $row['Estado_nombre'];

                $fileURL = "../Adjuntos_tmp/" . $adjunto; // Ruta completa del archivo adjunto
                $fileName = basename($fileURL); // Obtener el nombre del archivo
            }
        } else {
            echo "No se encontraron solicitudes con el ID proporcionado.";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $MySQLiconn->error;
    }
} else {
    echo "No se proporcionó un ID de solicitud en el URL.";
}


?>

