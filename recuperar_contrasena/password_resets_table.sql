-- Documentación para la creación de la tabla password_resets
-- Esta tabla almacena los tokens de restablecimiento de contraseñas

-- Crear la tabla si no existe
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(250) NOT NULL,
    token VARCHAR(32) NOT NULL,
    expiry DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX password_reset_email_index (email)
);

-- Descripción de los campos:
-- email: Correo electrónico del usuario que solicita restablecer su contraseña
-- token: Token único generado aleatoriamente usando bin2hex(random_bytes(16)) en PHP
-- expiry: Fecha y hora de caducidad del token
-- created_at: Fecha y hora de creación del registro
-- updated_at: Fecha y hora de la última actualización del registro

-- Ejemplo de código PHP para generar un token e insertarlo:
/*
<?php
function createPasswordReset($email) {
    $token = bin2hex(random_bytes(16));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $sql = "INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)";
    // Ejecutar consulta con los parámetros: $email, $token, $expiry
    
    return $token;
}
?>
*/

-- Ejemplo de consulta para verificar un token:
-- SELECT * FROM password_resets WHERE email = 'usuario@ejemplo.com' AND token = 'abc123...' AND expiry > NOW();

-- Ejemplo de consulta para eliminar tokens expirados:
-- DELETE FROM password_resets WHERE expiry < NOW();

-- Ejemplo de consulta para eliminar token después de usarlo:
-- DELETE FROM password_resets WHERE email = 'usuario@ejemplo.com' AND token = 'abc123...';