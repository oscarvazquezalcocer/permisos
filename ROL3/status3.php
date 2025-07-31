<?php
include_once '../DB/Db.php';

// Incluir la librería PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function getRolID() { 
    // Función que obtiene el ID del rol de la sesión actual
    if (session_start()) {
        return isset($_SESSION['rolID']) ? $_SESSION['rolID'] : null;
    } else {
        return null;  // Maneja el caso en el que la sesión no se inicie correctamente
    }
}

// Función para obtener el 'Rol_nombre' del rol desde la base de datos
function getRolInfoFromSession($MySQLiconn)
{
    // Obtener el ID del rol de la sesión actual
    $rolID = getRolID();

    $queryRol = "SELECT Rol_nombre FROM rol WHERE ID = $rolID";
    $resultRol = $MySQLiconn->query($queryRol);

    // Verificar si se encontró el resultado
    if ($resultRol && $resultRol->num_rows > 0) {
        $row = $resultRol->fetch_assoc();
        return $row;
    } else {
        // Agrega un mensaje de depuración para entender por qué la consulta no tiene resultados
        echo "Error en la consulta SQL para obtener el Rol: " . $MySQLiconn->error;
        return null;
    }
}

// Obtener información del rol actual
$rolInfo = getRolInfoFromSession($MySQLiconn);

// Verifica si la información del rol se obtuvo correctamente
if ($rolInfo !== null) {
    $rolNombre = $rolInfo['Rol_nombre'];
} else {
    // Maneja el caso en el que la información del rol no se obtuvo correctamente
    echo "Error al obtener la información del rol.";
    exit;
}

// Verifica si se proporcionó un ID de solicitud en el URL
if (isset($_GET['id'])) {
    $solicitudID = $_GET['id'];

    // Verifica si se envió el formulario y el botón "Aceptar" o "Rechazar" se presionó
    if (isset($_POST['Aceptar']) || isset($_POST['Rechazar'])) {

        // Obtén el valor de 'Gose de Sueldo' y 'el mensaje del motivo' del formulario
        $gsueldo = isset($_POST['gsueldo']) ? $_POST['gsueldo'] : '';
        $cmensaje = isset($_POST['confirM']) ? $_POST['confirM'] : '';

        // Guarda el valor en la base de datos
        $updateQuery = "UPDATE solicitud SET sueldo = '$gsueldo', mensaje = '$cmensaje', modified_by = '$rolNombre' WHERE ID = $solicitudID";
        $MySQLiconn->query($updateQuery);

        // Realiza la consulta para modificar los datos en la tabla
        $query = isset($_POST['Aceptar']) ? "UPDATE solicitud SET Estado_ID = 32" : "UPDATE solicitud SET Estado_ID = 33";
        $query .= " WHERE ID = $solicitudID";
        $mensaje = isset($_POST['Aceptar']) ? "Solicitud aceptada exitosamente !!!" : "Solicitud rechazada exitosamente !!!";

        // Correo electrónico obtenido
        $email = getEmail($solicitudID, $MySQLiconn);

       //  Instancia de PHPMailer
       $mail = new PHPMailer;
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com'; // Dirección del servidor SMTP utilizado; en este caso GMAIL
       $mail->Port = 587; // Puerto del servidor SMTP
       $mail->SMTPAuth = true;
       $mail->Username = 'permisos@valladolid.tecnm.mx'; // Correo electronico administrador
       $mail->Password = 'hjm7mDN>PR>69hV<'; // Contraseña
       $mail->setFrom('permisos@valladolid.tecnm.mx', 'GESTOR DE PERMISOS WEB'); // Remitente 

        // Destinatario
        $mail->addAddress($email); // Dirección de correo electrónico del usuario obtenida desde la base de datos

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = isset($_POST['Aceptar']) ? 'Solicitud Aceptada' : 'Solicitud Rechazada';
        $mail->Body = isset($_POST['Aceptar']) ? ' ¡Felicidades! :) Su solicitud ha sido aceptada. Inicie sesión para más detalles...' : ' ¡Ups! :( Su solicitud ha sido rechazada. Inicie sesión para más detalles...';

        // Enviar el correo electrónico
        if (!$mail->send()) {
            echo 'El mensaje no pudo ser enviado.';
            echo 'Error de correo electrónico: ' . $mail->ErrorInfo;
        } else {
            echo 'Correo electrónico enviado exitosamente.';
        }

        if ($MySQLiconn->query($query) === TRUE) {
            // Prepara la URL de redirección con el mensaje como parámetro
            $mensaje = urlencode($mensaje);
            $redirectURL = "Inicio3.php?msg=" . $mensaje;

            // Redirige al usuario a la otra página
            header("Location: " . $redirectURL);
            exit; // Importante: asegúrate de terminar la ejecución del script después de la redirección
        } else {
            echo "Error al modificar la solicitud: " . $MySQLiconn->error;
        }
    } else {
        exit;
    }
} else {
    echo "No se proporcionó un ID de solicitud en el URL.";
}

// Función para obtener el correo electrónico del usuario desde la base de datos
function getEmail($solicitudID, $MySQLiconn)
{
    $queryUsuario = "SELECT email FROM usuario WHERE id = (SELECT User_ID FROM solicitud WHERE ID = $solicitudID)";
    $resultUsuario = $MySQLiconn->query($queryUsuario);

    // Verificar si se encontró el resultado
    if ($resultUsuario && $resultUsuario->num_rows > 0) {
        $row = $resultUsuario->fetch_assoc();
        return $row['email'];
    } else {
        return null;
    }
}
?>
