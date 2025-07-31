<?php
include_once '../DB/Db.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Motivos </title>
  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link hacia los archivos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  <!-- Link hacia el archivo de estilos css -->
  <link rel="stylesheet" href="../CSS/Inicio.css">
  <link rel="stylesheet" href="../CSS/Normalize.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

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
      <li class="nivel1"><a href="Inicio3.php" class="nivel1"><span class="glyphicon glyphicon-home"></span>
          &nbsp Inicio</a></li>
      <li class="nivel1"><a href="bitacora.php" class="nivel1">Bitacora</a></li>
      <li class="nivel1"><a href="historial3.php" class="nivel1">Historial</a></li>
      <li class="nivel1"><a href="#" class="nivel1" id="hov"><span class="glyphicon glyphicon-cog"></span> &nbsp;
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

  <section class="center-container3">
    <div class="container-fluid">
      <div>
        <h2>Motivos</h2>
        <hr class="border border-primary border-2 opacity-75">
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <?php
      if (isset($_GET['msg'])) {
        $mensaje = urldecode($_GET['msg']);
        echo '<div class="alert alert-info">' . $mensaje . '</div>';
      }
      ?>

      <div id="texto-izquierda">
        <h2>Listado de Motivos</h2>
        <br>
        <div id="texto-left" class="form-group">
          <div class="col-12">
            <button type="button" class="btn btn-primary btn-lg"
              onclick="window.location.href='AddM.php'">Agregar</button>
          </div>
        </div>
      </div>

      <table class="table table-hover table-bordered table table-light table-striped">
        <tr>
          <th>Id</th>
          <th>Motivo</th>
          <th>Valor</th>
          <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT * from motivo";
        $result = $MySQLiconn->query($sql);
        while ($mostrar = mysqli_fetch_array($result)) {
          ?>

          <tr>
            <td>
              <?php echo $mostrar['ID']; ?>
            </td>
            <td>
              <?php echo $mostrar['Motivo_nombre']; ?>
            </td>
            <td>
              <?php echo $mostrar['Motivo_valor']; ?>
            </td>
            <td>
              <a href="E_mtv.php?ID=<?php echo $mostrar['ID'] ?>" onclick="return confirm('¿Seguro deseas eliminarlo?'); ">
                <span class="glyphicon glyphicon-trash"></span>
              </a>
            </td>
          </tr>
          <?php
        }
        ?>
      </table>

    </div>
  </section>


</body>

</html>