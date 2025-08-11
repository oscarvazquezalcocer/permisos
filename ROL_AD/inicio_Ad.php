<?php
include_once '../DB/Db.php';
require_once '../classes/SessionManager.php';
require_once '../views/components/navbar.php';

// session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Inicializar el manager de sesión y verificar permisos
$sessionManager = SessionManager::getInstance($MySQLiconn);
$sessionManager->requireRole(23); // Solo administradores pueden acceder a esta página
$title = 'Inicio Administrador';
$description = 'Página de inicio para administradores';
?>


<?php include_once __DIR__ . '/../views/partials/head.php'; ?>

<body id="texto-normal"> 
    <?php include_once __DIR__ . '/../views/partials/header.php'; ?>

    <?php // Componente de navegacion navbar
        $navItems = [
            ['label' => 'Inicio', 'href' => 'inicio_Ad.php', 'active' => true],
            ['label' => 'Usuarios', 'href' => 'usuarios.php'],
            ['label' => 'Datos de Usuarios', 'href' => 'datosuser.php']
        ];

        renderNavbar($navItems, $sessionManager);
    ?>

    <section class="center-container2">
        <div class="tback">
            <br>
            <h2>Información de Usuario</h2>
            <br>
            <h3>ADMINISTRADOR</h3>
            <img id="mg" src="../IMG/user.png" alt="Icono user" width="200" height="200">
        </div>
        <div>
            <?php
            // Verificar si el nombre de usuario está presente en la sesión
            if ($sessionManager->isLoggedIn()) {
                $user = $sessionManager->getUsuario();
                $username = $user->getUserName();
                $nombre = $user->getNombreCompleto();
                $puesto = $user->getPerfil()->getPuesto();
                $area = $user->getPerfil()->getArea();

                // Mostrar los datos del usuario en el HTML
                echo '<br>';
                echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Usuario:</b><br> ' . $username . '</p>';
                echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Nombre:</b><br> ' . $nombre . '</p>';
                echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Puesto:</b><br> ' . $puesto . '</p>';
                echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Area de Adscripcion:</b><br> ' . $area . '</p>';
                
            } else {
                echo '<p style="margin-top:48px; font-size: 20px; color: #ff0000;">Inicie sesión para ver los datos correspondientes.</p>';
            }
            ?>
        </div>

    </section>

    <?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>