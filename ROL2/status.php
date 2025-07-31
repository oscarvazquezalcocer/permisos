<?php
include_once '../DB/Db.php';

// Incluir la libreria PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function getUserID() { 
    // Funcion que obtiene el id del usuario de la sesion actual
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['userID']; 
}


// Función para obtener el 'Rol_nombre' y 'area_usuario_nombre' del usuario desde la base de datos
function getUserInfoFromSession($MySQLiconn)
{
    // Obtener el ID del usuario de la sesión actual
    $userID = getUserID();

    $queryUsuario = "SELECT usuario.email, rol.Rol_nombre, area_usuario.area_usuario_nombre 
                     FROM usuario
                     JOIN rol ON usuario.Rol_ID = rol.ID
                     JOIN area_usuario ON usuario.Area_usuario_ID = area_usuario.ID
                     WHERE usuario.id = $userID";
    $resultUsuario = $MySQLiconn->query($queryUsuario);

    // Verificar si se encontró el resultado
    if ($resultUsuario && $resultUsuario->num_rows > 0) {
        $row = $resultUsuario->fetch_assoc();
        return $row;
    } else {
        return null;
    }
}

// Obtener información del usuario actual
$userInfo = getUserInfoFromSession($MySQLiconn);

// Acceder a los valores obtenidos
$rolNombre = $userInfo['Rol_nombre'];
$areaUsuarioNombre = $userInfo['area_usuario_nombre'];
$rolYArea = $rolNombre . ' - ' . $areaUsuarioNombre;



// Verifica si se proporcionó un ID de solicitud en el URL
if (isset($_GET['id'])) {
    $solicitudID = $_GET['id'];

    // Verifica si se envió el formulario y el botón "Aceptar" o "Rechazar" se presionó
    if (isset($_POST['Aceptar'])) {
        // Realiza la consulta para modificar los datos en la tabla
        $query = "UPDATE solicitud SET Estado_ID = 34 WHERE ID = $solicitudID";
        $mensaje = "Solicitud aceptada exitosamente !!!";

    } elseif (isset($_POST['Rechazar'])) {

        // Obtén el valor de 'el mensaje del motivo' del formulario
        $cmensaje = isset($_POST['confirM']) ? $_POST['confirM'] : '';

        // Guarda el valor en la base de datos
        $updateQuery = "UPDATE solicitud SET mensaje = '$cmensaje', modified_by = '$rolYArea' WHERE ID = $solicitudID";
        $MySQLiconn->query($updateQuery);

        // Realiza la consulta para modificar los datos en la tabla
        $query = "UPDATE solicitud SET Estado_ID = 33 WHERE ID = $solicitudID";
        $mensaje = " Solicitud rechazada exitosamente !!!";

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

        // Correo electronico obtenido
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
        $mail->addAddress($email); // dirección de correo electrónico del usuario obtenida desde la base de datos

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Solicitud Rechazada';
        $mail->Body = ' ¡Ups! :( Su solicitud ha sido rechazada. Inicie sesión para mas detalles...';

        // Enviar el correo electrónico
        if (!$mail->send()) {
            echo 'El mensaje no pudo ser enviado.';
            echo 'Error de correo electrónico: ' . $mail->ErrorInfo;
        } else {
            echo 'Correo electrónico enviado exitosamente.';
        }


    } else {}

    if ($MySQLiconn->query($query) === TRUE) {
        // Prepara la URL de redirección con el mensaje como parámetro
        $mensaje = urlencode($mensaje);
        $redirectURL = "Inicio2.php?msg=" . $mensaje;

        // Redirige al usuario a la otra página
        header("Location: " . $redirectURL);
        exit; // Importante: asegúrate de terminar la ejecución del script después de la redirección
    } else {
        echo "Error al modificar la solicitud: " . $MySQLiconn->error;
    }
} else {
    echo "No se proporcionó un ID de solicitud en el URL.";
}

