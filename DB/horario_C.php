<?php
include_once 'Db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $horaInicio = $MySQLiconn->real_escape_string($_POST['horaInicio']);
    $horaFin = $MySQLiconn->real_escape_string($_POST['horaFin']);
    $horaInicio2 = $MySQLiconn->real_escape_string($_POST['horaInicio2']);
    $horaFin2 = $MySQLiconn->real_escape_string($_POST['horaFin2']);
    $motivo = $MySQLiconn->real_escape_string($_POST['motivo']);
    $otroM = isset($_POST['otroM']) ? $MySQLiconn->real_escape_string($_POST['otroM']) : NULL;

    // Concatena los valores de dos datos en una nueva variable
    $horario_establecido = $horaInicio . ' - ' . $horaFin;
    $horario_modificado = $horaInicio2 . ' - ' . $horaFin2;

    $tipoSolicitudID = 43;
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

            // Inserta datos en la tabla solicitud
            $sql = "INSERT INTO solicitud (User_ID, Tipo_solicitud_ID, hora_establecida, hora_modificada, motivo, otro, Estado_ID)
                    VALUES ('$userID', '$tipoSolicitudID', '$horario_establecido', '$horario_modificado', '$motivo', '$otroM', '$estadoID')";

            if ($MySQLiconn->query($sql)) {
                // Muestra ventana emergente con mensaje de solicitud exitosa
                echo '<script>
                alert("Solicitud enviada exitosamente."); window.location.href = "../ROL1/Inicio.php";</script>';
            } else {
                echo "Error al insertar los datos: " . $MySQLiconn->error;
            }
        } else {
            echo "No se encontró el User_ID del usuario actual.";
        }
    } else {
        echo "El nombre de usuario no está presente en la sesión.";
    }
}

// Cerrar la conexión
$MySQLiconn->close();
?>
