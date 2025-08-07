<?php
include_once '../DB/Db.php';
require_once '../classes/SessionManager.php';
require_once '../classes/SolicitudManager.php';

// session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Inicializar el manager de sesión y verificar permisos
$sessionManager = SessionManager::getInstance($MySQLiconn);
$sessionManager->requireRole(24); // Solo recursos humanos


// Obtener usuario actual
$usuario = $sessionManager->getUsuario();
$perfil = $usuario->getPerfil();

$solicitudManager = new SolicitudManager($MySQLiconn, $usuario);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Inicio </title>
  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Link hacia los archivos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <!-- Link hacia el archivo de estilos css -->
  <link rel="stylesheet" href="../CSS/Inicio.css">
  <link rel="stylesheet" href="../CSS/Normalize.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

  <link rel="stylesheet" href="../assets/js/bootstrap.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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
      <li class="nivel1"><a href="Inicio3.php" class="nivel1" id="hov"><span class="glyphicon glyphicon-home"></span>
          &nbsp Inicio</a></li>
      <li class="nivel1"><a href="bitacora.php" class="nivel1">Bitacora</a></li>
      <li class="nivel1"><a href="historial3.php" class="nivel1">Historial</a></li>
      <li class="nivel1"><a href="#" class="nivel1"><span class="glyphicon glyphicon-cog"></span> &nbsp;
          Configuración</a>
        <ul class="nivel2">
          <li><a href="motivo.php">Agregar motivo</a></li>
          <li><a>
              <form action="../DB/logout.php" method="POST">
                <button type="submit" style="font-size: 15px; background-color: black; border:none;"
                  class="btn btn-secondary">
                  <span class="glyphicon glyphicon-log-out"></span> &nbsp;
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
      <h2>Información de Usuario</h2>
      <div>
        <?php if ($sessionManager->isLoggedIn()): ?>
          <br>
          <p><h4><b>Username:</b> <?php echo htmlspecialchars($usuario->getUsername()); ?></h4></p>
          <p><h4><b>Nombre:</b><br> <?php echo htmlspecialchars($usuario->getNombreCompleto()); ?></h4></p>
          <p><h4><b>Puesto:</b><br> <?php echo htmlspecialchars($perfil->getPuesto()); ?></h4></p>
          <p><h4><b>Area de Adscripcion:</b><br> <?php echo htmlspecialchars($perfil->getArea()); ?></h4></p>
        <?php else: ?>
          <p>Error al cargar información del usuario</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="right-container" id="texto-centrar">
      <h2 class="bolt-lightning">Solicitudes Actuales</h2><br>
      <div class="h4">

        <?php if (isset($_GET['msg'])) : ?>
        <div class="alert alert-info"><?php echo urldecode($_GET['msg']); ?></div>
        <?php endif; ?>
        <!-- Tabla de Solicitudes -->
        <br>
        <table class="table table-hover table-bordered table table-light table-striped">
          <tr>
            <td><strong>ID</strong></td>
            <td><strong>TIPO</strong></td>
            <td><strong>NOMBRE</strong></td>
            <td><strong>PUESTO</strong></td>
            <td><strong>FECHA SOLIC.</strong></td>
            <td><strong>MOTIVO</strong></td>
            <td><strong>ACCIONES</strong></td>
          </tr>

          <?php

          // Verificar si el nombre de usuario está presente en la sesión
          if ($sessionManager->isLoggedIn()) {
            // $username = $_SESSION['username'];

            // $query = "SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, perfil.nombre, perfil.puesto, solicitud.Request_at, solicitud.motivo
            // FROM solicitud
            // JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
            // JOIN perfil ON solicitud.User_ID = perfil.User_ID
            // WHERE solicitud.Estado_ID NOT IN (31, 32, 33)";
            $result = $solicitudManager->obtenerSolicitudesActivasExcepto([31, 32, 33]);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
              // Iterar sobre los resultados y generar las filas de la tabla
              while ($row = $result->fetch_assoc()) {
                $solicitudID = $row['ID'];
                $tipoSolicitudNombre = $row['Tipo_solicitud_nombre'];
                $nombre = $row['nombre'];
                $puesto = $row['puesto'];
                $requestAt = $row['Request_at'];
                $motivo = $row['motivo'];

                // Generar una fila de la tabla con los datos de la solicitud
                echo '<tr>';
                echo '<td>' . $solicitudID . '</td>';
                echo '<td>' . $tipoSolicitudNombre . '</td>';
                echo '<td>' . $nombre . '</td>';
                echo '<td>' . $puesto . '</td>';
                echo '<td>' . $requestAt . '</td>';
                echo '<td>' . $motivo . '</td>';
                echo '<td><a href="../ROL3/view3.php?id=' . $solicitudID . '" class="btn btn-info btn-lg">
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
              echo '<strong>No hay solicitudes realizadas actualmente !!!</strong>';
              echo '</div>';
            }
          } else {
            echo 'Inicie sesión para ver los datos correspondientes';
          }
          ?>
        </table>

        <br>


      </div>
    </div>
  </section>


  <footer class="sfooter">
    <div id="texto-centrar" class="text-white">
      <h4>@ Gestor de Permisos Web</h4>
    </div>
  </footer>

</body>

</html>