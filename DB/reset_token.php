<?php

session_start();

// Backend para la recuperación de contraseña por medio de un enlace enviado al correo electrónico del usuario.
// con un token único que expira en una hora junto con el email del usuario.
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Importar las clases necesarias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once 'Db.php';
include_once __DIR__ . '/../SMTP/serverMail.php';

// Leer APP_URL desde el archivo .env y construir la BASE_URL
$env = parse_ini_file(__DIR__ . '/../.env');
$appUrl = isset($env['APP_URL']) ? rtrim($env['APP_URL'], '/') : '';
define('BASE_URL', $appUrl . '/recuperar_contrasena/');


// ------------------------------------------------------------------------------------ //
// Script para manejar la solicitud de recuperación de contraseña
// ------------------------------------------------------------------------------------ //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtener el email del formulario
    $email = $MySQLiconn->real_escape_string($_POST['email']);

    // verificar existencia del email en la base de datos
    $query = "SELECT id FROM usuario WHERE email = '$email'";
    $user = $MySQLiconn->query($query);

    // si el email no existe, mostrar un mensaje de error
    if ($user->num_rows !== 1) {
        $_SESSION['resultado_email'] = [
            'exito' => false,
            'mensaje' => 'El correo electrónico no está registrado.'
        ];

        echo '
            <script>
                window.location.href = "../recuperar_contrasena/enviar-email.php";
            </script>';

            exit();
    }
    
    // si el email existe, crear un enlace de recuperación
    $resetLink = createResetLink($email);
    
    if ($resetLink !== null) {
        // enviar el enlace de recuperación por correo electrónico
        $mailer = Mailer();
        $plantillaPath = __DIR__ . '/../plantillas/enlace_nueva_contrasena.html';
        $resultado = enviarCorreoConPlantilla(
            $mailer, 
            $email, 
            'Restablecimiento de contraseña',
            $plantillaPath, 
            [
                'Titulo' => 'Restablecimiento de contraseña',
                'AppUrl' => BASE_URL,
                'PasswordUrl' => $resetLink
            ]
        );
        
         // Guardar resultado en sesión
        $_SESSION['resultado_email'] = $resultado;
        
        // redirigir al formulario de envío
        echo '
            <script>
                window.location.href = "../recuperar_contrasena/enviar-email.php";
            </script>';
    }
}

/**
 * Crea un enlace de recuperación de contraseña y lo almacena en la base de datos.
 * 
 * @param string $email Correo electrónico del usuario
 * @return string|null Enlace de recuperación o null en caso de error
 */
function createResetLink($email): ?string
{
    // generar y almacenar el token de recuperación
    $token = createPasswordResetToken($email);
    
    if ($token === null) {
        echo '
            <script>
                alert("Hubo un error en el proceso de recuperación. Inténtelo de nuevo más tarde."); 
                window.location.href = "../index.php";
            </script>';
        return null;
    }

    // Incluir el email en el enlace de recuperación (codificado para seguridad)
    $encodedEmail = urlencode($email);
    $resetUrl = BASE_URL . "nueva-contrasena.php?token=" . $token . "&email=" . $encodedEmail;

    return $resetUrl;
}


/**
 * Crea un token de recuperación de contraseña y lo almacena en la base de datos.
 * 
 * @param string $email Correo electrónico del usuario
 * @return string|null Token de recuperación o null en caso de error
 */
function createPasswordResetToken($email): ?string
{
    global $MySQLiconn;

    // Obtener la zona horaria desde el archivo .env
    $env = parse_ini_file(__DIR__ . '/../.env');
    if (isset($env['APP_TIMEZONE'])) {
        date_default_timezone_set($env['APP_TIMEZONE']);
    }

    // token aleatorio de 16 bytes
    $token = bin2hex(random_bytes(16));

    // fecha de expiración del token
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // limpiar tokens anteriores para el mismo email
    $stmt = $MySQLiconn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // insertar el nuevo token
    $stmt = $MySQLiconn->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expiry);
    
    return $stmt->execute() ? $token : null;
}