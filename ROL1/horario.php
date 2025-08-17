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
            ['label' => 'Justificación Médica', 'href' => 'Justificacion.php'],
            ['label' => 'Cambio de Horario', 'href' => 'horario.php', 'active' => true]
        ]
    ],
    ['label' => 'Historial', 'href' => 'historial.php'],
];

$title = 'Solicitud Cambio de Horario';
$description = 'Página de solicitud de cambio de horario';
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
                <h2>&bull; Cambio de Horario o Compactación &bull;</h2>
            </div>
            <br>
            <div class="cuadroTexto">
                <strong> INFORMA QUE SUFRIRA CAMBIO DE HORARIO... </strong>
            </div>
            <br>
            <br>
            <form id="form_horario" class="formulario" action="../DB/horario_C.php" method="Post">

                <div class="cuadroTexto2">
                    <strong> HORARIO ESTABLECIDO </strong>
                </div>
                <div class="campo">
                    <label class="campo__label" for="horaInicio">Hora de inicio:</label>
                    <input type="time" id="horaInicio" name="horaInicio" required>
                </div>
                <div class="campo">
                    <label class="campo__label" for="horaFin">Hora de finalización:</label>
                    <input type="time" id="horaFin" name="horaFin" required>
                </div>
                <br>

                <div class="cuadroTexto2">
                    <strong> HORARIO MODIFICADO </strong>
                </div>
                <div class="campo">
                    <label class="campo__label" for="horaInicio2">Hora de inicio:</label>
                    <input type="time" id="horaInicio2" name="horaInicio2" required>
                </div>
                <div class="campo">
                    <label class="campo__label" for="horaFin2">Hora de finalización:</label>
                    <input type="time" id="horaFin2" name="horaFin2" required>
                </div>

                <br>
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

                <div class="campo">
                    <input type="submit" value="Solicitar" class="boton boton--primario">
                </div>
            </form>
        </div>
    </main>

    <?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>