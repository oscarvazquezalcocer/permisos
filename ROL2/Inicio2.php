<?php
include_once '../DB/Db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Inicio_2 </title>
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


  <nav id="menu2" class="navbar navbar-expand-lg bg-black" data-bs-theme="dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li id="hov" class="nav-item"><a class="nav-link active" aria-current="page" href="Inicio2.php">Inicio</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="historial2.php">Historial</a></li>
        </ul>
        <ul class="navbar-nav navbar-right">
          <li>
            <form action="../DB/logout.php" method="POST">
              <button type="submit" class="btn btn-secondary me-5">
                <span class="glyphicon glyphicon-log-out me-3"></span> &nbsp;
                Cerrar Sesión
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="contenedor-principal">
    <div class="left-container">
      <h2>Información de Usuario</h2>
      <div>
        <?php


        // Verificar si el nombre de usuario está presente en la sesión
        if (isset($_SESSION['username'])) {
          $username = $_SESSION['username'];

          // Realizar una consulta con JOIN para obtener los datos de usuario y perfil
          $query = "SELECT usuario.username, perfil.nombre, perfil.apellido, perfil.puesto, perfil.area, area_usuario.area_usuario_nombre
                        FROM usuario
                        JOIN perfil ON usuario.id = perfil.User_ID
                        JOIN area_usuario ON usuario.area_usuario_id = area_usuario.ID
                        WHERE usuario.username = '$username'";
          $result = $MySQLiconn->query($query);

          if ($result->num_rows == 1) {
            // Obtener los datos del usuario y perfil desde el resultado de la consulta
            $row = $result->fetch_assoc();
            $nombre = $row['nombre'];
            $apellido = $row['apellido'];
            $puesto = $row['puesto'];
            $area = $row['area'];
            $area_usuario = $row['area_usuario_nombre'];

            // Mostrar los datos del usuario en el HTML
            echo '<br>';
            echo '<p><h4><b>Jefe Directo de </b><br> ' . $area_usuario . '</h4></p>';
            echo '<p><h4><b>Username:</b> ' . $username . '</h4></p>';
            echo '<p><h4><b>Nombre:</b><br> ' . $nombre . ' ' . $apellido . '</h4></p>';
            echo '<p><h4><b>Puesto:</b><br> ' . $puesto . '</h4></p>';
            echo '<p><h4><b>Area de Adscripcion:</b><br> ' . $area . '</h4></p>';
          } else {
            echo 'No se encontró un usuario con el nombre de usuario proporcionado';
          }
        } else {
          echo 'Inicie sesión para ver los datos correspondientes';
        }
        ?>
      </div>
    </div>

    <div class="right-container" id="texto-centrar">
      <h2 class="bolt-lightning">Solicitudes Actuales</h2><br>
      <div class="h4">
        <?php
        if (isset($_GET['msg'])) {
          $mensaje = urldecode($_GET['msg']);
          echo '<div class="alert alert-info">' . $mensaje . '</div>';
        }
        ?>
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
          if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $area_usuario_id = $_SESSION['area_usuario_id']; // Suponiendo que tienes el área del usuario en la sesión
          
            $query = "SELECT solicitud.ID, tipo_solicitud.Tipo_solicitud_nombre, perfil.nombre, perfil.puesto, solicitud.Request_at, solicitud.motivo
              FROM solicitud
              JOIN tipo_solicitud ON solicitud.Tipo_solicitud_ID = tipo_solicitud.ID
              JOIN perfil ON solicitud.User_ID = perfil.User_ID
              JOIN usuario ON solicitud.User_ID = usuario.id
              WHERE solicitud.Estado_ID = 31
              AND usuario.area_usuario_id = $area_usuario_id"; // Agregamos la condición para el área del usuario
          
            $result = $MySQLiconn->query($query);

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
                echo '<td><a href="../ROL2/view2.php?id=' . $solicitudID . '" class="btn btn-info btn-lg">
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