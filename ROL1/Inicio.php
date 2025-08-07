<?php
session_start();
include_once '../DB/Db.php';
require_once '../classes/SessionManager.php';
require_once '../classes/SolicitudManager.php';

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

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title> Inicio </title>
  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link hacia el archivo de estilos css -->
  <link rel="stylesheet" href="../CSS/Inicio.css">
  <link rel="stylesheet" href="../CSS/Normalize.css">

  <!-- Link hacia los archivos de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
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
      <li class="nivel1"><a href="Inicio.php" class="nivel1" id="hov"><img src="../IMG/house-solid.svg">
          &nbsp Inicio</a></li>
      <li class="nivel1"><a href="#" class="nivel1">Solicitar</a>
        <ul class="nivel2">
          <li><a href="Permiso.php">Permiso</a></li>
          <li><a href="Justificacion.php">Justificacion Médica</a></li>
          <li><a href="horario.php">Cambio de Horario</a></li>
        </ul>
      </li>
      <li class="nivel1"><a href="historial.php" class="nivel1">Historial</a></li>
      <li class="nivel1"><a href="#" class="nivel1">Cuenta</a>
        <ul class="nivel2">
          <li><a>
              <form action="../DB/logout.php" method="POST">
                <button type="submit" style="font-size: 15px; background-color: black; border:none;"
                  class="btn btn-secondary">
                  <img src="../IMG/log-out.svg"> &nbsp;
                  Cerrar Sesión
                </button>
              </form>
            </a></li>
        </ul>
      </li>
    </ul>
  </nav>



  <section class="contenedor-principal">
    <div class="left-container">
      <h4>Información de Usuario</h4>
      <img src="../IMG/person-lines-fill.svg">
      <div>
        <?php if ($sessionManager->isLoggedIn()): ?>
          <br>
          <p><h6><b>Username:</b> <?php echo htmlspecialchars($usuario->getUsername()); ?></h6></p>
          <p><h6><b>Nombre:</b><br> <?php echo htmlspecialchars($usuario->getNombreCompleto()); ?></h6></p>
          <p><h6><b>Puesto:</b><br> <?php echo htmlspecialchars($perfil->getPuesto()); ?></h6></p>
          <p><h6><b>Area de Adscripcion:</b><br> <?php echo htmlspecialchars($perfil->getArea()); ?></h6></p>
          <p><h6><b>Jefe Directo:</b><br> <?php echo htmlspecialchars($usuario->getAreaUsuarioNombre()); ?></h6></p>
        <?php else: ?>
          <p>Error al cargar información del usuario, inicie sesión para ver los datos correspondientes.</p>
        <?php endif; ?>

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

          xhr.onreadystatechange = function () {
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


  <footer class="sfooter">
    <div id="texto-centrar" class="text-white">
      <h6> @Gestor de Permisos Web </h6>
    </div>
  </footer>

</body>

</html>