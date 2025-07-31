<?php
session_start();
include_once '../DB/Db.php';
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Historial </title>
  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Link hacia los archivos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <!-- Link hacia el archivo de estilos css -->
  <link rel="stylesheet" href="../CSS/Inicio.css">
  <link rel="stylesheet" href="../CSS/Normalize.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/js/bootstrap.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
      <li class="nivel1"><a href="Inicio.php" class="nivel1"><span class="glyphicon glyphicon-home"></span> &nbsp Inicio</a></li>
      <li class="nivel1"><a href="#" class="nivel1">Solicitar</a>
        <ul class="nivel2">
          <li><a href="Permiso.php">Permiso</a></li>
          <li><a href="Justificacion.php">Justificacion Médica</a></li>
          <li><a href="horario.php">Cambio de Horario</a></li>
        </ul>
      </li>
      <li class="nivel1"><a href="historial.php" class="nivel1" id="hov">Historial</a></li>
      <li class="nivel1"><a href="#" class="nivel1">Cuenta</a>
        <ul class="nivel2">
          <li><a>
            <form action="../DB/logout.php" method="POST">
                <button type="submit" style="font-size: 15px; background-color: black; border:none;" class="btn btn-secondary">
                  <span class="glyphicon glyphicon-log-out"></span> &nbsp;
                  Cerrar Sesión
                </button>
            </form>
          </a></li>
        </ul>
      </li>
    </ul>
  </nav>
  
  <section class="center-container" id="texto-centrar">
              <h1 class="bolt-lightning">Historial de Solicitudes</h1>
      <br><br>
      <div id="items-centrados">
        <div class="h4">
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
        

        // Verificar si el nombre de usuario está presente en la sesión
        if (isset($_SESSION['username'])) {
          $username = $_SESSION['username'];

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

                // Generar una fila de la tabla con los datos de la solicitud
                echo '<tr>';
                echo '<td>' . $solicitudID . '</td>';
                echo '<td>' . $tipoSolicitudNombre . '</td>';
                echo '<td>' . $requestAt . '</td>';
                echo '<td>' . $motivo . '</td>';
                echo '<td>' . $estadoNombre . '</td>';
                echo '<td><a  href="view.php?id=' . $solicitudID . '" class="btn btn-info btn-lg">
                <span class="glyphicon glyphicon-eye-open"></span> Ver mas..
                </a>
                </td>';
                echo '</tr>';
            }
        } else {
            // No se encontraron solicitudes en la tabla
            echo '</table>';
            echo '<div>';
            echo '<br>';
            echo '<strong>No hay solicitudes finalizadas actualmente !!!</strong>';
            echo '</div>';
          }
        } else {
            echo 'El nombre de usuario no está presente en la sesión';
        }
        ?>
        </table>
        </div>
  </section>

  <footer class="sfooter">
    <div id="texto-centrar" class="text-white">
      <h4>@ Gestor de Permisos Web</h4>
    </div>
  </footer>


</body>

</html>