<?php
session_start();
include_once '../DB/Db.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link hacia el archivo de estilos css -->
    <link rel="stylesheet" href="../CSS/Solicitar.css">
    <title>Permiso</title>
    <link rel="icon" href="IMG/logIts.png" type="image/png">
</head>

<header>
    <main>
        <div id="barra"> <!-- Barra donde estan los logos y el titulo del sistema -->
            GESTOR DE PERMISOS WEB (GPW)
            <img src="../IMG/LogoTecNMBlanco.png" class="log1">
            <img src="../IMG/LogIts.png" class="log2">
            <img src="../IMG/Logo.png" class="log3">
            <div class="rectangulo1"></div>
            <div class="rectangulo2"></div>
            <div class="rectangulo3"></div>
            <div class="Icon">
                <span class="glyphicon glyphicon-menu-hamburger"></span> <!-- Icono de Bootstrap -->
            </div>
        </div>

        <div id="menu"> <!-- Menu Desplegable -->
            <ul>
                <li class="nivel1"><a href="Inicio.php" class="nivel1">Inicio</a></li>
                <li class="nivel1"><a href="#" class="nivel1" style="background-color: rgb(49, 49, 49);">Solicitar</a>
                    <ul class="nivel2">
                        <li><a href="Permiso.php">Permiso</a></li>
                        <li><a href="Justificacion.php">Justificacion Médica</a></li>
                        <li><a href="horario.php">Cambio de Horario</a></li>
                    </ul>
                </li>
                <li class="nivel1"><a href="historial.php" class="nivel1">Historial</a></li>
                <li class="nivel1"><a href="#" class="nivel1">Tu cuenta</a>
                    <ul class="nivel2">
                        <li><a>
                                <form action="../DB/logout.php" method="POST">
                                    <button type="submit"
                                        style="font-size: 15px; background-color: black; border:none; color:white;"
                                        class="btn btn-secondary">
                                        <span class="glyphicon glyphicon-log-out"></span> &nbsp;
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </main>
</header>

<body>
    <main class="contenedorS">
        <div>
            <div class="cuadradoS">
                <h1>&bull; Solicitud De Permiso &bull;</h1>
            </div>
            <br>
            <br>
            <div class="cuadroTexto">
                <strong> SOLICITA PERMISO PARA AUSENTARSE DE SUS LABORES... </strong>
            </div>
            <br>
            <br>
            <form class="formulario" action="../DB/permiso_C.php" method="POST">

                <div class="campo">
                    <label class="campo__label" for="fecha1">DE FECHA: </label>
                    <input type="datetime-local" name="fecha1" id="Horario" required>
                </div>

                <div class="campo">
                    <label class="campo__label" for="fecha2">A FECHA: </label>
                    <input type="datetime-local" name="Fecha2" id="Fecha" required>
                </div>


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
                    <textarea class="campo__field campo__field--textarea" placeholder="Escribe otro motivo" id="otroM"
                        name="otroM" disabled rows="2"></textarea>
                </div>

                <div class="campo">
                    <input type="submit" title="Solicitar Permiso" value="Solicitar" class="boton boton--primario">
                </div>

                <div class="Nota">
                    <br> NOTA: Esta justificación podrá ser realizada hasta dos dias
                    <br> habiles posteriores a la fecha en que incurrio la inasistencia<br>
                </div>

            </form>

            <script src="../JS/disabled.js"></script>

        </div>
    </main>

    <footer class="sfooter">
        <div class="text-white">
            <h3>Gestor de Permisos Web</h3>
        </div>
    </footer>

</body>

</html>