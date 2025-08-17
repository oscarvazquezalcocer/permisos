<?php
/**
 * Ejemplo básico de envío de correo electrónico usando PHPMailer
 * 
 * Este script demuestra cómo enviar un correo electrónico simple
 * utilizando la librería PHPMailer y la configuración SMTP de Gmail.
 */

// Cargar el autoloader de Composer (si estás usando Composer)
// Si no tienes Composer, necesitarás incluir manualmente los archivos de PHPMailer
// require 'vendor/autoload.php';

// Incluir manualmente los archivos de PHPMailer (si no usas Composer)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Importar las clases necesarias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once 'SMTP/serverMail.php';

// Función para enviar correo
function enviarCorreo($destinatario, $asunto, $contenido) {
    try {
        // Obtener la configuración base de PHPMailer
        // Esta función debe estar definida en el archivo SMTP/serverMail.php
        $mail = Mailer();
        
        // Destinatario
        $mail->addAddress($destinatario);
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $contenido;
        $mail->AltBody = strip_tags($contenido); // Versión en texto plano
        
        // Enviar correo
        $mail->send();
        return [
            'exito' => true,
            'mensaje' => 'Correo enviado correctamente'
        ];
    } catch (Exception $e) {
        return [
            'exito' => false,
            'mensaje' => "Error al enviar correo: {$mail->ErrorInfo}"
        ];
    }
}

// Ejemplo de uso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinatario = isset($_POST['email']) ? $_POST['email'] : '';
    $asunto = isset($_POST['asunto']) ? $_POST['asunto'] : 'Correo de prueba';
    $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : 'Este es un correo de prueba enviado desde PHPMailer';
    
    $resultado = enviarCorreo($destinatario, $asunto, $mensaje);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Envío de Correo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #dff0d8;
            border: 1px solid #d0e9c6;
            color: #3c763d;
        }
        .alert-danger {
            background-color: #f2dede;
            border: 1px solid #ebcccc;
            color: #a94442;
        }
    </style>
</head>
<body>
    <h1>Envío de Correo Electrónico con PHPMailer</h1>
    
    <?php if (isset($resultado)): ?>
        <div class="alert <?php echo $resultado['exito'] ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $resultado['mensaje']; ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="email">Correo del destinatario:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="asunto">Asunto:</label>
            <input type="text" id="asunto" name="asunto" required>
        </div>
        
        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="6" required></textarea>
        </div>
        
        <button type="submit">Enviar Correo</button>
    </form>

    <h2>Análisis sobre el uso de PHPMailer</h2>
    <div>
        <h3>Ventajas de usar PHPMailer:</h3>
        <ul>
            <li>Fácil implementación y configuración</li>
            <li>Soporte para SMTP autenticado</li>
            <li>Capacidad para enviar correos HTML con archivos adjuntos</li>
            <li>Manejo de errores robusto</li>
            <li>Amplia documentación y comunidad activa</li>
            <li>Soporte para TLS/SSL para conexiones seguras</li>
        </ul>
        
        <h3>Alternativas:</h3>
        <ul>
            <li><strong>Swift Mailer:</strong> Similar a PHPMailer, pero con sintaxis diferente</li>
            <li><strong>Symfony Mailer:</strong> Componente de correo electrónico del framework Symfony</li>
            <li><strong>función mail() nativa de PHP:</strong> Más simple pero con menos funcionalidades y problemas de seguridad</li>
        </ul>

        <p><strong>Conclusión:</strong> PHPMailer es una excelente opción para proyectos de cualquier tamaño que requieran funcionalidades avanzadas de correo. Es especialmente útil cuando necesitas autenticación SMTP, como en este caso con Gmail.</p>
    </div>
</body>
</html>