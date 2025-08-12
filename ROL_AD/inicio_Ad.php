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

    <section class="container center-container2 my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <img src="../IMG/user.png" alt="Icono user" class="rounded-circle mb-3 border border-3" width="150" height="150">
                        <h3 class="card-title mb-2 text-primary">ADMINISTRADOR</h3>
                        <h5 class="mb-4 text-muted">Información de Usuario</h5>
                        <?php
                        if ($sessionManager->isLoggedIn()) {
                            $user = $sessionManager->getUsuario();
                            $username = $user->getUserName();
                            $nombre = $user->getNombreCompleto();
                            $puesto = $user->getPerfil()->getPuesto();
                            $area = $user->getPerfil()->getArea();

                            echo '<ul class="list-group list-group-flush text-start">';
                            echo '<li class="list-group-item"><strong>Usuario:</strong> ' . htmlspecialchars($username) . '</li>';
                            echo '<li class="list-group-item"><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</li>';
                            echo '<li class="list-group-item"><strong>Puesto:</strong> ' . htmlspecialchars($puesto) . '</li>';
                            echo '<li class="list-group-item"><strong>Área de Adscripción:</strong> ' . htmlspecialchars($area) . '</li>';
                            echo '</ul>';
                        } else {
                            echo '<div class="alert alert-warning mt-4" role="alert">Inicie sesión para ver los datos correspondientes.</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>