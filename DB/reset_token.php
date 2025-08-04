<?php

// Backend para la recuperación de contraseña por medio de un enlace enviado al correo electrónico del usuario.
// con un token único que expira en una hora junto con el email del usuario.
include_once 'Db.php';

// base url
define('BASE_URL', 'http://permisos.test/recuperar_contrasena/');

// datos a recibir, email
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtener el email del formulario
    $email = $MySQLiconn->real_escape_string($_POST['email']);

    // verificar existencia del email en la base de datos
    $query = "SELECT id FROM usuario WHERE email = '$email'";
    $user = $MySQLiconn->query($query);

    // si el email no existe, mostrar un mensaje de error
    if ($user->num_rows !== 1) {
        echo '
            <script>
                alert("El correo electrónico ingresado no está registrado."); 
                window.location.href = "../index.php";
            </script>';
        exit();
    }
    
    // si el email existe, crear un enlace de recuperación
    $resetLink = createResetLink($email);
    
    if ($resetLink !== null) {
        // enviar el enlace de recuperación por correo electrónico
        // Aquí implementar la lógica para enviar el correo electrónico

    }
}

// crear enlace de recuperacion 
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

    // TODO: Mostrar el enlace de recuperación en el mensaje (solo para testeo)
    echo '
    <script>
        alert("Se ha enviado un enlace de recuperación a su correo electrónico. (TEST: ' . $resetUrl . ')"); 
        window.location.href = "../index.php";
    </script>';

    return $resetUrl;
}


// generar token de recuperacion, almacenarlo y retornarlo
function createPasswordResetToken($email): ?string
{
    global $MySQLiconn;

    // Establecer la zona horaria adecuada
    date_default_timezone_set('America/Mexico_City');

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