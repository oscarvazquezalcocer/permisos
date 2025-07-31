<?php
include_once '../DB/Db.php';
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Bitacora </title>
  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Link hacia los archivos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  <!-- Link hacia el archivo de estilos css -->
  <link rel="stylesheet" href="../CSS/Inicio.css">
  <link rel="stylesheet" href="../CSS/Normalize.css">
  <link rel="stylesheet" href="../assets/js/bootstrap.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
  <link rel="icon" href="IMG/logIts.png" type="image/png">
</head>

<body id="texto-normal">

  <header id="barra" class="text-white">
    <!-- Barra donde estan los logos y el titulo del sistema -->
    GESTOR DE PERMISOS WEB (GPW)
    <img src="../IMG/LogoTecNMBlanco.png" class="log1">
    <img src="../IMG/LogIts.png" class="log2">
    <img src="../IMG/Logo.png" class="log3">
    <div class="rectangulo1"></div>
    <div class="rectangulo2"></div>
  </header>

  <nav class="menu" id="texto-normal">
    <!-- Menu Desplegable -->
    <ul>
      <li class="nivel1"><a href="Inicio3.php" class="nivel1"><span class="glyphicon glyphicon-home"></span> &nbsp
          Inicio</a></li>
      <li class="nivel1"><a href="bitacora.php" class="nivel1" id="hov">Bitacora</a></li>
      <li class="nivel1"><a href="Historial3.php" class="nivel1">Historial</a></li>
      <li class="nivel1"><a href="#" class="nivel1"><span class="glyphicon glyphicon-cog"></span> &nbsp;
          Configuración</a>
        <ul class="nivel2">
          <li><a href="motivo.php">Agregar motivo</a></li>
          <li><a>
              <form action="../DB/logout.php" method="POST">
                <button type="submit" class="btn btn-secondary"
                  style="font-size: 15px; background-color: black; border:none;">
                  <span class="glyphicon glyphicon-log-out"></span> &nbsp;
                  Cerrar Sesión
                </button>
              </form>
            </a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <section class="center-container2" id="texto-centrar">
    <h1 class="bolt-lightning">Bitacora de Solicitudes:</h1>
    <br>
    <div id="texto-izquierda">
      <h3>Listado de Solicitudes</h3>
      <br>
      <form method="POST" action="">
      <label for="menuDesplegable">Seleccione tipos de solicitud:</label>
      <select id="menuDesplegable" name="tipoSolicitud">
        <option value="Permiso" <?php echo (isset($_POST['tipoSolicitud']) && $_POST['tipoSolicitud'] == 'Permiso') ? 'selected' : ''; ?>>Permiso</option>
        <option value="Justificación Médica" <?php echo (isset($_POST['tipoSolicitud']) && $_POST['tipoSolicitud'] == 'Justificación Médica') ? 'selected' : ''; ?>>Justificación Médica</option>
        <option value="Cambio de horario o Compactación" <?php echo (isset($_POST['tipoSolicitud']) && $_POST['tipoSolicitud'] == 'Cambio de horario o Compactación') ? 'selected' : ''; ?>>Cambio de horario o
          Compactación</option>
      </select>
      <input type="submit" value="Filtrar">
    </form>
    </div><br>



    <div class="container-fluid">
      <form class="d-flex">
        <input class="form-control m-2 light-table-filter" data-table="table_id" type="text" placeholder="BUSCAR">
        <hr>
      </form>
      <br>
    </div>


    <div id="items-centrados">

      <table class="table table-hover table-bordered table table-light table-striped table_id">
        <?php
        if(isset($_SESSION['username'])) {
          $username = $_SESSION['username'];


          // Realiza la consulta para obtener los datos de la solicitud específica
          $query = "SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, perfil.nombre, perfil.apellido, perfil.puesto, perfil.area,
            solicitud.Request_at, solicitud.de_fecha, solicitud.a_fecha, solicitud.reposicion, solicitud.fecha_r1, solicitud.fecha_r2,
            solicitud.sueldo, solicitud.hora_establecida, solicitud.hora_modificada, solicitud.motivo, solicitud.otro, solicitud.adjunto, estado.Estado_nombre
            FROM solicitud
            JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
            JOIN perfil ON solicitud.User_ID = perfil.User_ID
            JOIN estado ON solicitud.Estado_ID = estado.ID
            WHERE solicitud.Estado_ID IN (32)";


          if(isset($_POST['tipoSolicitud'])) {
            $tipoSolicitudSeleccionado = $_POST['tipoSolicitud'];
            // Ajusta tu consulta SQL para incluir el filtro
            $query .= " AND tipo_solicitud.Tipo_solicitud_nombre = '$tipoSolicitudSeleccionado'";
          }

          $result = $MySQLiconn->query($query);

          // Verifica si se encontraron solicitudes en la tabla
          if($result->num_rows > 0) {
            echo '<tr class="fw-bold">
              <td>ID</td>
              <td>TIPO</td>
              <td>Nombre del Solicitante</td>
              <td>Puesto</td>
              <td>Area</td>
              <td>Solicitado en</td>
              <td>Fecha Solicitada</td>
              <td>Reposicion</td>
              <td>Fecha Reposicion</td>
              <td>Sueldo</td>
              <td>Hora Establecida</td>
              <td>Hora Modificada</td>
              <td>Motivo</td>
              <td>Otro Motivo</td>
              <td>Adjunto</td>
              <td>Estatus</td>
            </tr>';

            while($row = $result->fetch_assoc()) {
              $solicitudID = $row['ID'];
              $tipoSolicitudNombre = $row['Tipo_solicitud_nombre'];
              $nombre = $row['nombre'];
              $apellido = $row['apellido'];
              $puesto = $row['puesto'];
              $area = $row['area'];
              $requestAt = $row['Request_at'];
              $deFecha = $row['de_fecha'];
              $aFecha = $row['a_fecha'];
              $reposicion = $row['reposicion'];
              $fechaR1 = $row['fecha_r1'];
              $fechaR2 = $row['fecha_r2'];
              $gsueldo = $row['sueldo'];
              $horaEstablecida = $row['hora_establecida'];
              $horaModificada = $row['hora_modificada'];
              $motivo = $row['motivo'];
              $otro = $row['otro'];
              $adjunto = $row['adjunto'];
              $estadoNombre = $row['Estado_nombre'];

              $fileURL = "../Adjuntos_tmp/".$adjunto; // Ruta completa del archivo adjunto
              $fileName = basename($fileURL); // Obtener el nombre del archivo
        
              // Verifica cada campo y si no está vacío ni es nulo, lo incluye en la salida HTML
              echo '<tr>';
              echo '<td>'.(!empty($solicitudID) ? $solicitudID : '').'</td>';
              echo '<td>'.(!empty($tipoSolicitudNombre) ? $tipoSolicitudNombre : '').'</td>';
              echo '<td>'.(!empty($nombre) ? $nombre.' '.$apellido : '').'</td>';
              echo '<td>'.(!empty($puesto) ? $puesto : '').'</td>';
              echo '<td>'.(!empty($area) ? $area : '').'</td>';
              echo '<td>'.(!empty($requestAt) ? $requestAt : '').'</td>';
              echo '<td>'.((!empty($deFecha) && !empty($aFecha)) ? $deFecha.'  | A:   '.$aFecha : '').'</td>';
              echo '<td>'.(!empty($reposicion) ? $reposicion : '').'</td>';
              echo '<td>'.((!empty($fechaR1) && !empty($fechaR2)) ? $fechaR1.'   | A:   '.$fechaR2 : '').'</td>';
              echo '<td>'.(!empty($gsueldo) ? $gsueldo : '').'</td>';
              echo '<td>'.(!empty($horaEstablecida) ? $horaEstablecida : '').'</td>';
              echo '<td>'.(!empty($horaModificada) ? $horaModificada : '').'</td>';
              echo '<td>'.(!empty($motivo) ? $motivo : '').'</td>';
              echo '<td>'.(!empty($otro) ? $otro : '').'</td>';
              echo '<td>'.((!empty($adjunto) && !empty($fileURL)) ? $adjunto.' <a href="'.$fileURL.'" download="'.$fileName.'">_____
                    <span class="glyphicon glyphicon-download-alt"></span></a> ' : '').'</td>';
              echo '<td>'.(!empty($estadoNombre) ? $estadoNombre : '').'</td>';
              echo '</tr>';
            }
          } else {
            echo '<div>';
            echo '<br>';
            echo '<strong>No hay solicitudes Finalizadas actualmente !!!</strong>';
            echo '</div>';
          }
        }
        ?>
      </table>
    </div>

    <div>
      <button type="button" id="exportButton" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Exportar a Excel</button>
        <br><br><br>
    </div>

    <footer class="sfooter">
      <div id="texto-centrar" class="text-white">
        <h5>@Gestor de Permisos Web</h5>
      </div>
    </footer>

    <script src="../JS/search.js"></script>
    <script>
      document.getElementById('exportButton').addEventListener('click', function () {
        var table = document.querySelector('.table_id');
        var ws = XLSX.utils.table_to_sheet(table);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
        XLSX.writeFile(wb, 'solicitudes.xlsx');
      });
    </script>
</body>

</html>