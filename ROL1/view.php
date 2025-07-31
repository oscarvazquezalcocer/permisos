<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title> Datos </title>
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


<body>

  <header>
    <nav class="navbar bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
        <a style="font-size: 20px;" class="navbar-brand" href="#">GESTOR DE PERMISOS WEB (GPW)</a>
      </div>
    </nav>
  </header>

  <section>
    <div class="row justify-content-md-center">
    <div class="col col-lg-10">
      <div class="align-middle">
        <div id="texto-derecha">
          <button type="button" class="btn-close btn-lg" aria-label="Close" onclick="goBack()"></button>
        </div>
      </div>
      <div id="texto-izquierda">
        <h1 style="font-size: 40px;">Datos de la Solicitud</h1>
        <hr class="border border-primary border-3 opacity-75">
        <br>
      </div>

      <?php
      if (isset($_GET['id'])) {
        $solicitudID = $_GET['id'];
        include_once '../DB/datos.php';
      }
      ?>

      <?php
      include_once '../DB/datos.php';
      ?>

      <div class="table-responsive fs-4">
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
                <?php echo '<b>DE: </b>' .$deFecha . '<b> | A  FECHA: </b>' . $aFecha; ?>
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
                <?php echo '<b> DE: </b>' .$fechaR1 . '<b> | A FECHA: | </b>' . $fechaR2; ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php if (!empty($gsueldo)): ?>
            <tr>
              <td id="texto-izquierda" class="fw-bold">Gose de Sueldo</td>
              <td id="texto-izquierda">
                <?php echo $gsueldo; ?>
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
        </table>
      </div>
    </div>
    </div>
  </section>

  <script> function goBack() {window.history.back(); } </script>

</body>
</html>