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
        'active' => true,
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6.905 9.97a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72V18a.75.75 0 0 0 1.5 0v-4.19l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                </svg>',
        'dropdown' => [
            ['label' => 'Permiso', 'href' => 'Permiso.php'],
            ['label' => 'Justificación Médica', 'href' => 'Justificacion.php', 'active' => true],
            ['label' => 'Cambio de Horario', 'href' => 'horario.php']
        ]
    ],
    ['label' => 'Historial', 'href' => 'historial.php'],
];

$title = 'Solicitud Justificación Médica';
$description = 'Página de solicitud de permiso con justificación médica';
?>

<?php include_once __DIR__ . '/../views/partials/head.php'; ?>
<link rel="stylesheet" href="../CSS/Solicitar.css">
<?php include_once __DIR__ . '/../views/partials/header.php'; ?>

<body>
    <?php // Componente de navegacion navbar
        renderNavbar($navItems, $sessionManager);
    ?>

    <main class="contenedorS ">
        <div>
            <div class="cuadradoS">
                <h1>&bull; Justificación Médica &bull;</h1>
            </div>
            <br>
            <br>
            <div class="cuadroTexto">
                <strong> INFORMA QUE SE AUSENTÓ DE SUS LABORES... </strong>
            </div>
            <br>
            <br>
            <form class="formulario" action="../DB/justificacion_C.php" method="Post" enctype="multipart/form-data">

                <div class="campo">
                    <label class="campo__label" for="fecha1">DE FECHA: </label>
                    <input type="datetime-local" name="fecha1" id="Horario" required>
                </div>

                <div class="campo">
                    <label class="campo__label" for="fecha2">A FECHA: </label>
                    <input type="datetime-local" name="Fecha2" id="Fecha" required>
                </div>

                <br>
                <div class="campo">
                    <label class="campo__label" for="selec-reposicion">Reposicion</label>
                    <select name="reposicion" id="select-reposicion" onchange="toggleCamposReposicion()" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="Con reposicion">Con reposicion de horario</option>
                        <option value="Sin reposicion">Sin reposicion de horario</option>
                    </select>
                </div>

                <div class="campo">
                    <label class="campo__label" for="fechaRep1"> CON FECHA: </label>
                    <input type="datetime-local" name="fechaRep1" id="fechaRep1" disabled>
                </div>

                <div class="campo">
                    <label class="campo__label" for="fechaRep2"> A FECHA:</label>
                    <input type="datetime-local" name="fechaRep2" id="fechaRep2" disabled>
                </div>
                <br>

                <?php
                // Consulta los datos de la tabla 'motivo'
                $query = "SELECT Motivo_nombre FROM motivo";
                $result = $MySQLiconn->query($query);

                // Inicializa un array para almacenar los datos de motivo
                $motivoData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $motivoData[] = $row;
                    }
                }
                ?>

                <div class="campo">
                    <label class="campo__label" for="selec-motivo">MOTIVO</label>
                    <select name="motivo" id="select-motivo" onchange="toggleCamposMotivo()" required>
                        <option value="">Seleccione una opción</option>
                        <?php
                        // Genera las opciones del select con los datos de la tabla 'motivo'
                        foreach ($motivoData as $Lmotivo) {
                            echo '<option value="' . $Lmotivo['Motivo_nombre'] . '">' . $Lmotivo['Motivo_nombre'] . '</option>';
                        }
                        ?>
                        <option value="otro">Otro Motivo</option>
                    </select>
                </div>

                <div class="campo">
                    <label class="campo__label" for="otroM">Otro: </label>
                    <textarea class="campo__field campo__field--textarea" placeholder="Escribe otro motivo" id="otroM" disabled></textarea>
                </div>

                <div class="custom-input-file col-md-6 col-sm-6 col-xs-6">
                    <input type="file" name="adjunto" accept=".pdf,.jpg,.png" multiple required />
                </div>
                <br>
                <br>
                <div class="campo">
                    <input type="submit" value="Solicitar" class="boton boton--primario">
                </div>

                <div class="Nota">
                    <br> NOTA: Esta justificación podrá ser realizada hasta tres dias
                    <br> habiles posteriores a la fecha en que incurrio la inasistencia<br>
                </div>

            </form>
        </div>
    </main>

    <?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>