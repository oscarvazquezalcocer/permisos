<?php
/**
 * Uso de PHPMailer
 * 
 * Este archivo contiene funciones de ejemplo para diferentes
 * casos de uso de PHPMailer en un entorno de producción.
 */

// Importar las clases necesarias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Configuración base para todos los correos
 * 
 * @return PHPMailer Instancia configurada de PHPMailer
 */
function Mailer(): PHPMailer
{
    try {
        // Cargar variables de entorno desde .env (ubicado en el directorio raíz del proyecto)
        $envPath = dirname(__DIR__) . '/.env';
        if (file_exists($envPath)) {
            $env = parse_ini_file($envPath);
        } else {
            throw new Exception('.env file not found at ' . $envPath);
        }

        // true habilita excepciones
        $mail = new PHPMailer(true); 

        // Configuración del servidor SMTP usando variables de entorno
        $mail->isSMTP();
        $mail->Host = $env['MAIL_HOST'];
        $mail->Port = $env['MAIL_PORT'];
        $mail->SMTPAuth = true;
        $mail->Username = $env['MAIL_USERNAME'];
        $mail->Password = $env['MAIL_PASSWORD'];

        // Habilitar SMTPDebug si está definido en .env y es verdadero
        // Puede tener valores como: true, false, 1, 0, on, off, yes, no (no distingue mayúsculas/minúsculas)
        if (isset($env['MAIL_DEBUG']) && filter_var($env['MAIL_DEBUG'], FILTER_VALIDATE_BOOLEAN)) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        }
        $mail->SMTPSecure = $env['MAIL_ENCRYPTION'];
        $mail->CharSet = 'UTF-8';
        
        // Configuración del remitente
        $mail->setFrom($env['MAIL_FROM_ADDRESS'], $env['MAIL_FROM_NAME']);

        return $mail;
    } catch (Exception $e) {
        die("Error al configurar PHPMailer: " . $e->getMessage());
    }
}


/**
 * Envía un correo con una plantilla HTML
 * 
 * @param PHPMailer $mailer Instancia de PHPMailer configurada
 * @param string $destinatario Correo del destinatario
 * @param string $asunto Asunto del correo
 * @param string $rutaPlantilla Ruta al archivo de plantilla HTML
 * @param array $datos Datos para reemplazar en la plantilla
 * @return array Resultado del envío
 */
function enviarCorreoConPlantilla(PHPMailer $mailer, $destinatario, $asunto, $rutaPlantilla, $datos = []): array
{
    try {
        $mail = $mailer;
        
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