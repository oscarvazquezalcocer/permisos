<?php

// backend para la recuperacion de contrasena por medio de un enlace enviado al correo electrónico del usuario.
// con un token único que expira en una hora y email correspondiente.
include_once 'Db.php';

// datos a recibir, token, email codificado y nueva contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtener el token, email y la nueva contraseña del formulario
    $token = $MySQLiconn->real_escape_string($_POST['token']);
    
    $email = $MySQLiconn->real_escape_string($_POST['email']);
    $email = urldecode($email); // decodificar el email

    // verificar existencia del token y email en la base de datos
    if (!verifyToken($token, $email)) {
        echo '
            <script>
                alert("El enlace de recuperación es inválido o ha expirado."); 
                window.location.href = "../index.php";
            </script>';
        exit();
    }

    // si el token es válido, actualizar la contraseña del usuario
    $newPassword = $MySQLiconn->real_escape_string($_POST['nueva_contrasena']);
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // actualizar la contraseña en la base de datos
    $stmt = $MySQLiconn->prepare("UPDATE usuario SET password_hash = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        // limpiar el token de la base de datos
        clearToken($email, $token);
        
        // mostrar mensaje de éxito y redirigir al login
        echo '
            <script>
                alert("Contraseña actualizada exitosamente. Ahora puede iniciar sesión."); 
                window.location.href = "../index.php";
            </script>';
    } else {
        echo '
            <script>
                alert("Error al actualizar la contraseña. Inténtelo de nuevo más tarde."); 
                window.location.href = "../index.php";
            </script>';
    }
}


// verificar existencia del token en la base de datos
function verifyToken($token, $email): bool
{
    global $MySQLiconn;

    // Establecer zona horaria
    date_default_timezone_set('America/Mexico_City');

    $stmt = $MySQLiconn->prepare("SELECT * FROM password_resets WHERE email = ? AND token = ? AND expiry > NOW()");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

// limpiar el token de la base de datos una vez usado
function clearToken($email, $token): void
{
    global $MySQLiconn;

    $stmt = $MySQLiconn->prepare("DELETE FROM password_resets WHERE email = ? AND token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
}