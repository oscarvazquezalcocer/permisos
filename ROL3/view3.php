<?php
include_once '../DB/Db.php';
session_start();

if (isset($_GET['id'])) {
    $solicitudID = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title> Datos de la Solicitud</title>
    <!-- Responsividad -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link hacia el archivo de estilos css -->
    <link rel="stylesheet" href="../CSS/Inicio.css">
    <link rel="stylesheet" href="../CSS/Normalize.css">

    <!-- Link hacia los archivos de Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <link rel="icon" href="IMG/logIts.png" type="image/png">

</head>


<body>

    <header>
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid justify-content-center">
                <a class="navbar-brand" href="#">GESTOR DE PERMISOS WEB (GPW)</a>
            </div>
        </nav>
    </header>

    <section>
        <div class="center-container3">
            <div class="align-middle">
                <div id="texto-derecha">
                    <br>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="window.location.href = 'Inicio3.php'"></button>
                </div>
            </div>
            <div id="texto-izquierda">
                <h1 style="font-size: 30px;">Datos de la Solicitud</h1>
                <hr class="border border-primary border-3 opacity-75">

                <div>
                    <form id="form12" class="formulario" method="POST" action="status3.php?id=<?php echo $solicitudID; ?>">
                        <!-- Botón para abrir el modal de Aceptar -->
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#modalAceptar">
                            Aceptar
                        </button>

                        <!-- Botón para abrir el modal de Rechazar -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#modalRechazar">
                            Rechazar
                        </button>

                        <!-- Modal de Aceptar -->
                        <div class="modal fade" id="modalAceptar" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="modalAceptarLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="status3.php?id=<?php echo $solicitudID; ?>">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalAceptarLabel">Confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <select
                                                    class="form-select form-select-lg mb-3 fs-6 text-primary-emphasis"
                                                    name="gsueldo" required>
                                                    <option class="text-secondary-emphasis" value="">Seleccione una
                                                        opción...</option>
                                                    <option class="text-secondary-emphasis" value="Con gose de sueldo">
                                                        Con gose de sueldo
                                                    </option>
                                                    <option class="text-secondary-emphasis" value="Sin gose de sueldo">
                                                        Sin gose de sueldo
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <input type="submit" id="aceptarButton" name="Aceptar" value="Aceptar" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Rechazar -->
                        <div class="modal fade" id="modalRechazar" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="modalRechazarLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="status3.php?id=<?php echo $solicitudID; ?>">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalRechazarLabel">Confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Motivo:</label>
                                                <textarea class="form-control" id="confirMRechazar" name="confirM"
                                                    rows="3" required
                                                    placeholder="Escribe el motivo por el que se rechaza la solicitud"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <input type="submit" id="rechazarButton" name="Rechazar" value="Rechazar"
                                                class="btn btn-danger">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>





                <?php
                if (isset($_GET['id'])) {
                    $solicitudID = $_GET['id'];
                    include_once '../DB/datos2.php';
                }
                ?>

                <div class="table-responsive fs-6">

                    <br>
                    <div class="table-responsive fs-6">
                        <table class="table table-striped table-bordered ">
                            <?php if (!empty($tipoSolicitudNombre)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Tipo de Solicitud</td>
                                    <td id="texto-izquierda">
                                        <?php echo $tipoSolicitudNombre; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($nombre)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Nombre completo</td>
                                    <td id="texto-izquierda">
                                        <?php echo $nombre . ' ' . $apellido; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($puesto)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Puesto</td>
                                    <td id="texto-izquierda">
                                        <?php echo $puesto; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($area)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Area</td>
                                    <td id="texto-izquierda">
                                        <?php echo $area; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($requestAt)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Solicitado en</td>
                                    <td id="texto-izquierda">
                                        <?php echo $requestAt; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($deFecha)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Fecha Solicitada</td>
                                    <td id="texto-izquierda">
                                        <?php echo '<b>DE: </b>' . $deFecha . '<b> | A  FECHA: </b>' . $aFecha; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($reposicion)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Reposicion</td>
                                    <td id="texto-izquierda">
                                        <?php echo $reposicion; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($fechaR1)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Fecha de Reposicion</td>
                                    <td id="texto-izquierda">
                                        <?php echo '<b> DE: </b>' . $fechaR1 . '<b> | A FECHA: | </b>' . $fechaR2; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($horaEstablecida)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Horario Establecido</td>
                                    <td id="texto-izquierda">
                                        <?php echo $horaEstablecida; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($horaModificada)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Horario Modificado</td>
                                    <td id="texto-izquierda">
                                        <?php echo $horaModificada; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($motivo)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Motivo</td>
                                    <td id="texto-izquierda">
                                        <?php echo $motivo; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($otro)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Otro</td>
                                    <td id="texto-izquierda">
                                        <?php echo $otro; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($adjunto)): ?>
                                <tr>
                                    <td id="texto-izquierda" class="fw-bold">Archivo adjunto</td>
                                    <td id="texto-izquierda">
                                        <?php echo $adjunto; ?>
                                        <a href="<?php echo $fileURL; ?>" download="<?php echo $fileName; ?>">
                                            <span class="glyphicon glyphicon-download-alt"> &nbsp </span></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                        </form>
                    </div>
                </div>
    </section>

</body>

</html>