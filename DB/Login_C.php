<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'Db.php';
require_once '../classes/SessionManager.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        header("Location: ../index.php?mensaje=Error por favor complete todos los campos");
        exit();
    }

    try {
        // Inicializar el manager de sesión
        $sessionManager = SessionManager::getInstance($MySQLiconn);

        // Intentar hacer login
        if ($sessionManager->login($username, $password)) {
            $usuario = $sessionManager->getUsuario();
            $rolID = $usuario->getRolID();

            // Redirigir según el rol
            switch ($rolID) {
                case 23: // Administrador
                    header("Location: ../ROL_AD/inicio_Ad.php");
                    break;
                case 22: // Jefe
                    header("Location: ../ROL2/Inicio2.php");
                    break;
                case 24: // Recursos Humanos
                    header("Location: ../ROL3/Inicio3.php");
                    break;
                case 21: // Personal
                    header("Location: ../ROL1/Inicio.php");
                    break;
                case 25: // Inactivo
                    header("Location: ../ROL_IN/inicio_inactivo.php");
                    break;
                default:
                    // Rol desconocido, redirigir a página por defecto
                    header("Location: ../ROL1/Inicio.php");
                    break;
            }
            exit();
        } else {
            // Credenciales incorrectas
            header("Location: ../index.php?mensaje=Datos de usuario incorrectos. Intente de nuevo");
            exit();
        }
    } catch (Exception $e) {
        // Error del servidor
        error_log("Error en login: " . $e->getMessage());
        header("Location: ../index.php?mensaje=Error del servidor. Intente más tarde");
        exit();
    }
} else {
    // Acceso directo no permitido
    header("Location: ../index.php?mensaje=Acceso no válido");
    exit();
}
?>