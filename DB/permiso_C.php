<?php

session_start();
include_once 'Db.php';

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $fecha1 = $MySQLiconn->real_escape_string($_POST['fecha1']);
    $fecha2 = $MySQLiconn->real_escape_string($_POST['Fecha2']);
    $reposicion = $MySQLiconn->real_escape_string($_POST['reposicion']);
    $fechaRep1 = isset($_POST['fechaRep1']) ? $MySQLiconn->real_escape_string($_POST['fechaRep1']) : NULL;
    $fechaRep2 = isset($_POST['fechaRep2']) ? $MySQLiconn->real_escape_string($_POST['fechaRep2']) : NULL;
    $motivo = $MySQLiconn->real_escape_string($_POST['motivo']);
    $otroM = isset($_POST['otroM']) ? $MySQLiconn->real_escape_string($_POST['otroM']) : NULL;

    $tipoSolicitudID = 41;
    $estadoID = 31;

    // Verifica si el nombre de usuario está presente en la sesión
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Obtén el User_ID del usuario actual
        $query = "SELECT id FROM usuario WHERE username = '$username'";
        $result = $MySQLiconn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $userID = $row['id'];

            // Crea la consulta SQL con parámetros preparados
            $sql = "INSERT INTO solicitud (User_ID, Tipo_solicitud_ID, de_fecha, a_fecha, reposicion, fecha_r1, fecha_r2, motivo, otro, Estado_ID)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepara la declaración SQL con parámetros
            $stmt = $MySQLiconn->prepare($sql);

            // Vincula los valores a los parámetros
            $stmt->bind_param("iisssssssi", $userID, $tipoSolicitudID, $fecha1, $fecha2, $reposicion, $fechaRep1, $fechaRep2, $motivo, $otroM, $estadoID);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                // Muestra ventana emergente con mensaje de solicitud exitosa
                echo '<script>alert("Solicitud enviada exitosamente."); window.location.href = "../ROL1/Inicio.php";</script>';
            } else {
                echo "Error al insertar los datos: " . $stmt->error;
            }

            // Cierra la declaración
            $stmt->close();
        } else {
            echo "No se encontró el User_ID del usuario actual.";
        }
    } else {
        echo "INICIE SESION PARA PODER REALIZAR UNA SOLICITUD";
    }

    // Cierra la conexión
    $MySQLiconn->close();
}
?>
