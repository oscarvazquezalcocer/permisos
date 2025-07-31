<?php
include_once '../DB/Db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Usuarios </title>
  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link hacia los archivos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  <!-- Link hacia el archivo de estilos css -->
  <link rel="stylesheet" href="../CSS/Inicio.css">
  <link rel="stylesheet" href="../CSS/Normalize.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  
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

    <nav id="menu2" class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
          <div class="collapse navbar-collapse">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item"><a class="nav-link active" aria-current="page" href="inicio_Ad.php">Inicio</a></li>
                  <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
                  <li id="hov" class="nav-item"><a class="nav-link" href="datosuser.php">Datos de Usuarios</a></li>
              </ul>
              <ul class="navbar-nav navbar-right">
                  <li>
                    <a>
                      <form action="../DB/logout.php" method="POST">
                          <button type="submit" class="btn btn-secondary">
                              <span class="glyphicon glyphicon-log-out"></span> &nbsp;
                              Cerrar Sesión
                          </button>
                      </form>
                    </a>
                  </li>
              </ul>
          </div>
      </div>
  </nav> 
  
<section class="center-container3">
    <div class="container-fluid">
        <div>
            <h2>Usuarios</h2>
            <hr class="border border-primary border-2 opacity-75">
        </div>
        <br>
        <br>
         <br>
          <br>
           <br>
          <div id="texto-izquierda">
            <h2>Listado de Datos de Usuarios</h2>
            
          <form class="d-flex">
          <input class="form-control m-2 light-table-filter" data-table="table_id" type="text" placeholder="BUSCAR">
            <hr>
          </form>
          </div>
      
          <br>
          <table class="table table-hover table-bordered table table-light table-striped table_id">
            <tr>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>sexo</th>
              <th>Area</th>
              <th>Puesto</th>
              <th>Creado</th>
              <th>Actualizado</th>
              <th>Numero_Usuario</th>
            </tr>
            <?php

            // Verificar si el  usuario está presente en la sesión
            if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

              $sqls="SELECT * from perfil";
              $result=$MySQLiconn->query($sqls);
              while($mostrars=mysqli_fetch_array($result)){
                ?>
              <tr class="data-row">
                <td><?php echo $mostrars['nombre']?></td>
                <td><?php echo $mostrars['apellido']?></td>
                <td><?php echo $mostrars['sexo']?></td>
                <td><?php echo $mostrars['area']?></td>
                <td><?php echo $mostrars['puesto']?></td>
                <td><?php echo $mostrars['create_at']?></td>
                <td><?php echo $mostrars['update_at']?></td>
                <td><?php echo $mostrars['User_ID']?></td>
              </tr>
              <?php
              }
            } else {
              echo '<p style="font-size: 20px; color: #ff0000;">Inicie sesión para ver los datos correspondientes.</p>';
            }
              ?>
          </table>
      
        </div>
  </section>

<script src="../JS/searchv2.js"></script>
</body>
</html>