<?php
require_once 'Db.php';
require_once '../classes/SessionManager.php';

try {
    $sessionManager = SessionManager::getInstance($MySQLiconn);
    $sessionManager->logout();
    
    // Redirigir al index
    header("Location: ../index.php?mensaje=Sesión cerrada correctamente");
    exit();
} catch (Exception $e) {
    error_log("Error en logout: " . $e->getMessage());
    header("Location: ../index.php?mensaje=Error al cerrar sesión");
    exit();
}
?>