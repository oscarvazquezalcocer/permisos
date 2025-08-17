<?php
/**
 * Ejemplos avanzados de uso de PHPMailer
 * 
 * Este archivo contiene funciones de ejemplo para diferentes
 * casos de uso de PHPMailer en un entorno de producción.
 */

// Importar las clases necesarias (asumiendo que tienes el autoloader de Composer o las includes manuales)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once 'SMTP/serverMail.php';

/**
 * Configuración base para todos los correos
 * 
 * @return PHPMailer Instancia configurada de PHPMailer
 */
function obtenerConfiguracionBase() {
    $mail = Mailer();
    return $mail;
}

/**
 * Envía un correo con una plantilla HTML
 * 
 * @param string $destinatario Correo del destinatario
 * @param string $asunto Asunto del correo
 * @param string $rutaPlantilla Ruta al archivo de plantilla HTML
 * @param array $datos Datos para reemplazar en la plantilla
 * @return array Resultado del envío
 */
function enviarCorreoConHtml($destinatario, $asunto, $rutaPlantilla, $datos = []) {
    try {
        $mail = obtenerConfiguracionBase();
        
        // Añadir destinatario
        $mail->addAddress($destinatario);
        
        // Cargar plantilla HTML
        $contenido = file_get_contents($rutaPlantilla);
        
        // Reemplazar variables en la plantilla
        foreach ($datos as $clave => $valor) {
            $contenido = str_replace('{{' . $clave . '}}', $valor, $contenido);
        }
        
        // Configurar contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $contenido;
        $mail->AltBody = strip_tags($contenido);
        
        // Enviar
        $mail->send();
        return ['exito' => true, 'mensaje' => 'Correo enviado correctamente'];
    } catch (Exception $e) {
        return ['exito' => false, 'mensaje' => "Error al enviar correo: {$mail->ErrorInfo}"];
    }
}

/**
 * Envía un correo con archivos adjuntos
 * 
 * @param string $destinatario Correo del destinatario
 * @param string $asunto Asunto del correo
 * @param string $mensaje Cuerpo del mensaje
 * @param array $archivosAdjuntos Rutas a los archivos adjuntos
 * @return array Resultado del envío
 */
function enviarCorreoConAdjuntos($destinatario, $asunto, $mensaje, $archivosAdjuntos = []) {
    try {
        $mail = obtenerConfiguracionBase();
        
        // Añadir destinatario
        $mail->addAddress($destinatario);
        
        // Adjuntar archivos
        foreach ($archivosAdjuntos as $archivo) {
            if (file_exists($archivo)) {
                $mail->addAttachment($archivo);
            }
        }
        
        // Configurar contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->AltBody = strip_tags($mensaje);
        
        // Enviar
        $mail->send();
        return ['exito' => true, 'mensaje' => 'Correo enviado correctamente'];
    } catch (Exception $e) {
        return ['exito' => false, 'mensaje' => "Error al enviar correo: {$mail->ErrorInfo}"];
    }
}

/**
 * Envía un correo a múltiples destinatarios
 * 
 * @param array $destinatarios Lista de correos destinatarios
 * @param string $asunto Asunto del correo
 * @param string $mensaje Cuerpo del mensaje
 * @return array Resultado del envío
 */
function enviarCorreoMasivo($destinatarios, $asunto, $mensaje) {
    try {
        $mail = obtenerConfiguracionBase();
        
        // Añadir múltiples destinatarios
        foreach ($destinatarios as $email) {
            $mail->addAddress($email);
        }
        
        // También puedes añadir destinatarios en CC o BCC
        // $mail->addCC('cc@ejemplo.com');
        // $mail->addBCC('bcc@ejemplo.com');
        
        // Configurar contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->AltBody = strip_tags($mensaje);
        
        // Enviar
        $mail->send();
        return ['exito' => true, 'mensaje' => 'Correo enviado correctamente a todos los destinatarios'];
    } catch (Exception $e) {
        return ['exito' => false, 'mensaje' => "Error al enviar correo: {$mail->ErrorInfo}"];
    }
}

/**
 * Envía un correo de restablecimiento de contraseña
 * 
 * @param string $email Correo del usuario
 * @param string $token Token de restablecimiento
 * @return array Resultado del envío
 */
function enviarCorreoRestablecerContrasena($email, $token) {
    // URL de restablecimiento
    $url = "https://permisos.valladolid.tecnm.mx/reset_password.php?email=" . urlencode($email) . "&token=" . urlencode($token);
    
    // Contenido HTML
    $mensaje = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .btn { display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; 
                  text-decoration: none; border-radius: 4px; }
            .footer { margin-top: 30px; font-size: 12px; color: #777; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Restablecer su contraseña</h2>
            <p>Hemos recibido una solicitud para restablecer la contraseña de su cuenta.</p>
            <p>Para continuar con este proceso, haga clic en el siguiente enlace:</p>
            <p><a href='{$url}' class='btn'>Restablecer contraseña</a></p>
            <p>O copie y pegue la siguiente URL en su navegador:</p>
            <p>{$url}</p>
            <p>Este enlace es válido por una hora.</p>
            <p>Si usted no solicitó restablecer su contraseña, puede ignorar este mensaje.</p>
            <div class='footer'>
                <p>Este es un mensaje automático, por favor no responda a este correo.</p>
                <p>GESTOR DE PERMISOS WEB - Instituto Tecnológico de Valladolid</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return enviarCorreoConHtml($email, "Restablecimiento de contraseña", "", ['mensaje' => $mensaje]);
}

/**
 * Ejemplo de uso de las funciones
 */
function ejemploDeUso() {
    // Ejemplo 1: Envío de correo simple
    $resultado1 = enviarCorreoConHtml(
        'tu.correo@ejemplo.com',
        'Prueba de correo con plantilla',
        'plantillas/correo.html',
        [
            'nombre' => 'Usuario',
            'mensaje' => 'Este es un mensaje de prueba con plantilla'
        ]
    );
    
    // Ejemplo 2: Envío de correo con archivos adjuntos
    $resultado2 = enviarCorreoConAdjuntos(
        'tu.correo@ejemplo.com',
        'Prueba de correo con archivos adjuntos',
        'Adjunto encontrará los documentos solicitados.',
        [
            'documentos/archivo1.pdf',
            'documentos/archivo2.docx'
        ]
    );
    
    // Ejemplo 3: Envío masivo
    $resultado3 = enviarCorreoMasivo(
        ['usuario1@ejemplo.com', 'usuario2@ejemplo.com', 'usuario3@ejemplo.com'],
        'Notificación importante',
        'Este es un mensaje para todos los usuarios'
    );
    
    // Ejemplo 4: Correo de restablecimiento de contraseña
    $resultado4 = enviarCorreoRestablecerContrasena(
        'usuario@ejemplo.com',
        'abc123token456'
    );
    
    // Mostrar resultados
    echo "<pre>";
    print_r($resultado1);
    print_r($resultado2);
    print_r($resultado3);
    print_r($resultado4);
    echo "</pre>";
}

// Descomentar para ejecutar los ejemplos
// ejemploDeUso();
?>