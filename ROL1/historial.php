<?php
session_start();
include_once '../DB/Db.php';
require_once '../classes/SessionManager.php';
require_once '../classes/SolicitudManager.php';
require_once '../views/components/navbar.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Inicializar el manager de sesión y verificar permisos
$sessionManager = SessionManager::getInstance($MySQLiconn);
$sessionManager->requireRole(21); // Solo personal

// Obtener usuario actual
$usuario = $sessionManager->getUsuario();

// ------ navbar componente ------
$navItems = [
    [
        'label' => 'Inicio',
        'href' => 'Inicio.php',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                </svg>',
    ],
    [
        'label' => 'Solicitar',
        'href' => '#',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6.905 9.97a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72V18a.75.75 0 0 0 1.5 0v-4.19l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                </svg>',
        'dropdown' => [
            ['label' => 'Permiso', 'href' => 'Permiso.php'],
            ['label' => 'Justificación Médica', 'href' => 'Justificacion.php'],
            ['label' => 'Cambio de Horario', 'href' => 'horario.php']
        ]
    ],
    ['label' => 'Historial', 'href' => 'historial.php', 'active' => true],
];

$title = 'Historial Personal';
$description = 'Página de historial de solicitudes para personal';

?>


<?php include_once __DIR__ . '/../views/partials/head.php'; ?>

<body id="texto-normal">

    <?php include_once __DIR__ . '/../views/partials/header.php'; ?>


    <?php // Componente de navegacion navbar
    renderNavbar($navItems, $sessionManager);
    ?>

    <section class="container-xxl" style="margin-top: 12.8rem;">
        <h2 class="bolt-lightning">Historial de Solicitudes</h2>
        <br><br>
        <div class="container-fluid">
            <div class="table-responsive">
                <table id="permisos" class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>TIPO PERMISO</th>
                            <th>FECHA</th>
                            <th>MOTIVO</th>
                            <th>STATUS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        // Verificar si el nombre de usuario está presente en la sesión
                        if ($sessionManager->isLoggedIn()) {
                            $username = $usuario->getUserName();

                            // Crear la consulta SQL para obtener las solicitudes del usuario
                            $query = "SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, solicitud.Request_at, estado.Estado_nombre, solicitud.motivo
                                    FROM solicitud
                                    JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
                                    JOIN estado ON solicitud.Estado_ID = estado.ID
                                    JOIN usuario ON solicitud.User_ID = usuario.id
                                    WHERE usuario.username = '$username' AND solicitud.Estado_ID NOT IN (31, 34)";
                            
                            $result = $MySQLiconn->query($query);

                            // Verificar si hay resultados
                            if ($result->num_rows > 0) {
                                // Iterar sobre los resultados y generar las filas de la tabla
                                while ($row = $result->fetch_assoc()) {
                                    $solicitudID = $row['ID'];
                                    $tipoSolicitudNombre = $row['Tipo_solicitud_nombre'];
                                    $requestAt = $row['Request_at'];
                                    $motivo = $row['motivo'];
                                    $estadoNombre = $row['Estado_nombre'];
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($solicitudID); ?></td>
                                        <td><?php echo htmlspecialchars($tipoSolicitudNombre); ?></td>
                                        <td><?php echo htmlspecialchars($requestAt); ?></td>
                                        <td><?php echo htmlspecialchars($motivo); ?></td>
                                        <td><?php echo htmlspecialchars($estadoNombre); ?></td>
                                        <td>
                                            <a  href="view.php?id=' . $solicitudID . '" class="btn btn-info btn-lg">
                                                <span class="glyphicon glyphicon-eye-open"></span> 
                                                Ver mas..
                                            </a>
                                        </td>';
                                    </tr>
                            <?php
                                }
                            } 
                        } else {
                            echo 
                            '<tr>
								<td colspan="8" class="text-center text-danger fw-bold">
									Inicie sesión para ver los datos correspondientes.
								</td>
							</tr>';
                        }
                        ?>
                    </thead>
                </table>
            </div>
    </section>

    <?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
    <script>
        initDataTable('permisos', {
            layout: {
                topStart: 'search',
                topEnd: 'pageLength',
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            responsive: true
        });
    </script>

</body>

</html>