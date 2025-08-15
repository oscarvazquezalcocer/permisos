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
$perfil = $usuario->getPerfil();

// Instancia solicitud manager
$solicitudManager = new SolicitudManager($MySQLiconn, $usuario);

// ------ navbar componente ------
$navItems = [
    [
        'label' => 'Inicio',
        'href' => 'Inicio.php',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                </svg>',
        'active' => true
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
    ['label' => 'Historial', 'href' => 'historial.php'],
];

$title = 'Inicio Personal';
$description = 'Página de inicio para personal';

?>

<?php include_once __DIR__ . '/../views/partials/head.php'; ?>
<?php include_once __DIR__ . '/../views/partials/header.php'; ?>

<body id="texto-normal">

    <?php // Componente de navegacion navbar
    renderNavbar($navItems, $sessionManager);
    ?>

    <section class="contenedor-principal">
        <div class="left-container">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>	
                    <h5 class="ms-2 mb-0">Información de Usuario</h5>
                </div>
                <div class="card-body">
                    <?php if ($sessionManager->isLoggedIn()): ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Username:</strong>
                                <span><?php echo htmlspecialchars($usuario->getUsername()); ?></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Nombre:</strong>
                                <span><?php echo htmlspecialchars($usuario->getNombreCompleto()); ?></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Puesto:</strong>
                                <span><?php echo htmlspecialchars($perfil->getPuesto()); ?></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Área de Adscripción:</strong>
                                <span><?php echo htmlspecialchars($perfil->getArea()); ?></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Jefe Directo:</strong>
                                <span><?php echo htmlspecialchars($usuario->getAreaUsuarioNombre()); ?></span>
                            </li>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0" role="alert">
                            Error al cargar información del usuario, inicie sesión para ver los datos correspondientes.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="right-container" id="texto-centrar">
            <h3 class="bolt-lightning">Solicitud Actual</h3>

            <?php
            // Verificar si el nombre de usuario está presente en la sesión
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];

                // Crear la consulta SQL para obtener la información específica de la solicitud Aceptada
                $querySolicitud32 = "SELECT sueldo, ID, modified_by, notificacion FROM solicitud WHERE Estado_ID = 32 AND notificacion = 0 AND User_ID = (SELECT id FROM usuario WHERE username = '$username') LIMIT 1";
                $resultSolicitud32 = $MySQLiconn->query($querySolicitud32);

                // Verificar si hay resultados
                if ($resultSolicitud32->num_rows == 1) {
                    $rowSolicitud32 = $resultSolicitud32->fetch_assoc();
                    $sueldo = $rowSolicitud32['sueldo'];
                    $solicitudID = $rowSolicitud32['ID'];
                    $modified2 = $rowSolicitud32['modified_by'];
                    $showCard = true; // Mostrar el card
                } else {
                    // Si no hay resultados
                    $sueldo = '..';
                    $showCard = false; // Ocultar el card
                }

                // Crear la consulta SQL para obtener la información específica de la solicitud Rechazada
                $querySolicitud33 = "SELECT mensaje, ID, modified_by, notificacion FROM solicitud WHERE Estado_ID = 33 AND notificacion = 0 AND User_ID = (SELECT id FROM usuario WHERE username = '$username') LIMIT 1";
                $resultSolicitud33 = $MySQLiconn->query($querySolicitud33);

                // Verificar si hay resultados
                if ($resultSolicitud33->num_rows == 1) {
                    $rowSolicitud33 = $resultSolicitud33->fetch_assoc();
                    $mensaje2 = $rowSolicitud33['mensaje'];
                    $solicitudID2 = $rowSolicitud33['ID'];
                    $modified = $rowSolicitud33['modified_by'];
                    $showCard2 = true; // Mostrar el card2
                } else {
                    // Si no hay resultados
                    $mensaje2 = 'No hay mensaje disponible';
                    $modified = 'Algo salio mal';
                    $showCard2 = false; // Ocultar el card2
                }
            } else {
                $showCard = false; // Ocultar el card si no hay usuario logueado
                $showCard2 = false;
            }
            ?>
            <?php

            // Lógica para mostrar los Cards
            $cards = array();  // Almacena los datos de los Cards

            // Card Aceptada
            if ($showCard) {
                $cards[] = array(
                    'id' => $solicitudID,
                    'mensaje' => $mensaje2,
                    'sueldo' => $sueldo,
                    'modified_by' => $modified2,
                    'estado' => 'success'
                );
            }

            // Card Rechazada
            if ($showCard2) {
                $cards[] = array(
                    'id' => $solicitudID2,
                    'mensaje' => $mensaje2,
                    'modified_by' => $modified,
                    'estado' => 'danger'
                );
            }

            // Mostrar los Cards
            foreach ($cards as $card) {
                $cardID = $card['id'];
                $cardMensaje = $card['mensaje'];
                $cardModified = $card['modified_by'];
                $cardSueldo = isset($card['sueldo']) ? $card['sueldo'] : '..';
                $cardEstado = $card['estado'];
            ?>

                <div id="myCard<?php echo $cardID; ?>" class="card">
                    <div class="card-header d-flex justify-content-between text-bg-<?php echo $cardEstado; ?>">
                        <span>Notificación</span>

                        <?php if ($cardEstado == 'success'): ?>
                            <!-- Botón close para estado 'success' -->
                            <button type="button" class="btn-close ms-auto" aria-label="Close"
                                onclick="closeCard(<?php echo $cardID; ?>, <?php echo $solicitudID; ?>)">
                            </button>
                        <?php elseif ($cardEstado == 'danger'): ?>
                            <!-- Botón close para estado 'danger' -->
                            <button type="button" class="btn-close ms-auto" aria-label="Close"
                                onclick="closeCard(<?php echo $cardID; ?>, <?php echo $solicitudID2; ?>)">
                            </button>
                        <?php endif; ?>

                    </div>
                    <div class="card-body row justify-content-around">
                        <div class="col-8">
                            <br>
                            <h5 class="card-title">
                                <?php echo $cardEstado == 'success' ? '<img src="../IMG/circle-check.svg">  Felicidades su solicitud ha sido ¡¡¡¡ ACEPTADA!!!! <img src="../IMG/emoji-smile.svg">'
                                    : '<img src="../IMG/circle-x.svg"> Ups su solicitud ha sido ¡¡¡¡ RECHAZADA !!!! <img src="../IMG/emoji-frown.svg">'; ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $cardSueldo; ?>
                            </p>
                            <p class="card-text">Responsable:
                                <?php echo $cardModified; ?>
                            </p>
                            <p class="card-text">Motivo:
                                <?php echo $cardMensaje; ?>
                            </p>
                        </div>
                        <div class="col-4">
                            <img src="../IMG/<?php echo $cardEstado == 'success' ? 'APROBADO' : 'RECHAZADO'; ?>.png">
                        </div>
                        <div class="col-6">
                            <a href="view.php?id='<?php echo $cardID; ?>'"
                                class="btn btn-<?php echo $cardEstado == 'success' ? 'success' : 'danger'; ?>">Ver solicitud</a>
                        </div>
                    </div>
                    <div class="card-footer text-bg-<?php echo $cardEstado; ?>">

                    </div>
                </div>
                <br><br>

            <?php
            }
            ?>

            <div class="h6">
                <?php
                // Verificar si el nombre de usuario está presente en la sesión
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];

                    // Crear la consulta SQL para obtener las solicitudes del usuario
                    $query = "SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, solicitud.Request_at, estado.Estado_nombre, solicitud.motivo
              FROM solicitud
              JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
              JOIN estado ON solicitud.Estado_ID = estado.ID
              JOIN usuario ON solicitud.User_ID = usuario.id
              WHERE usuario.username = '$username' AND solicitud.Estado_ID NOT IN (32, 33)";
                    $result = $MySQLiconn->query($query);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                ?>
                        <table class="table table-light table-striped">
                            <tr>
                                <td><strong>ID</strong></td>
                                <td><strong>TIPO PERMISO</strong></td>
                                <td><strong>FECHA</strong></td>
                                <td><strong>MOTIVO</strong></td>
                                <td><strong>STATUS</strong></td>
                                <td><strong>ACCIONES</strong></td>
                            </tr>
                            <?php
                            // Iterar sobre los resultados y generar las filas de la tabla
                            while ($row = $result->fetch_assoc()) {
                                $solicitudID = $row['ID'];
                                $tipoSolicitudNombre = $row['Tipo_solicitud_nombre'];
                                $requestAt = $row['Request_at'];
                                $motivo = $row['motivo'];
                                $estadoNombre = $row['Estado_nombre'];

                                // Generar una fila de la tabla con los datos de la solicitud
                                echo '<tr>';
                                echo '<td>' . $solicitudID . '</td>';
                                echo '<td>' . $tipoSolicitudNombre . '</td>';
                                echo '<td>' . $requestAt . '</td>';
                                echo '<td>' . $motivo . '</td>';
                                echo '<td>' . $estadoNombre . '</td>';
                                echo '<td><a href="view.php?id=' . $solicitudID . '" class="btn btn-info btn-sm">
                     <i><img src="../IMG/journal-text.svg"></i> Ver mas..
                  </a>
                </td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                <?php
                    } else {
                        // No se encontraron solicitudes en la tabla
                        echo '<br>';
                        echo '<strong>Actualmente No has realizado ninguna solicitud !!!</strong>';
                    }
                } else {
                    echo 'Inicie sesión para ver los datos correspondientes';
                }
                ?>
            </div>


            <script>
                function closeCard(solicitudID, cardID) {
                    console.log('Cerrando card con solicitudID:', solicitudID, 'y cardID:', cardID);

                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'update_notificacion.php?solicitudID=' + solicitudID, true);

                    xhr.onreadystatechange = function() {
                        try {
                            if (xhr.readyState == 4) {
                                if (xhr.status == 200) {
                                    console.log('Respuesta exitosa. Ocultando el card:', cardID);
                                    // Verifica si la respuesta contiene el mensaje esperado
                                    if (xhr.responseText.includes('Notificación actualizada')) {
                                        // Ocultar el contenedor del card
                                        document.getElementById('myCard' + solicitudID).style.display = 'none';
                                    } else {
                                        console.error('Respuesta del servidor inesperada:', xhr.responseText);
                                    }
                                } else {
                                    console.error('Error en la solicitud AJAX:', xhr.statusText);
                                }
                            }
                        } catch (error) {
                            console.error('Error inesperado:', error);
                        }
                    };

                    xhr.send();
                }
            </script>
            <br><br>

        </div>
        </div>
    </section>


    <?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>