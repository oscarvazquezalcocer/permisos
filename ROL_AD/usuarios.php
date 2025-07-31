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
                  <li id="hov" class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
                  <li class="nav-item"><a class="nav-link" href="datosuser.php">Datos de Usuario</a></li>
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
            <h2>Listado de Usuarios</h2>

            <br>
            <div id="texto-left" class="form-group">
              <div class="col-12">
              <?php
            // Verificarcion
            if (isset($_SESSION['username'])) {
               
            ?>
                <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='../registro.php'">Agregar</button>
            <?php
            } else {
         
            ?>
                <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='../ROL_AD/inicio_Ad.php'">Agregar</button>
            <?php
            }
            ?>
        </div>
          </div>
          </div>
        <div class="container-fluid">
          <form class="d-flex">
          <input class="form-control m-2 light-table-filter" data-table="table_id" type="text" placeholder="BUSCAR">
            <hr>
          </form>
          </div>
          <br>
          <table class="table table-hover table-bordered table table-light table-striped table_id">
            <tr>
              <th>#</th>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Tipo de Usuario</th>
              <th>Creado</th>
              <th>Actualizado</th>
              <th>Modificar</th>
            </tr>
            <?php

                  // Verificar si el  usuario está presente en la sesión
              if (isset($_SESSION['username'])) {
              $username = $_SESSION['username'];

              $sql="SELECT * from usuario";
              $result=$MySQLiconn->query($sql);
              while($mostrar=mysqli_fetch_array($result)){

              $id = $mostrar['Rol_ID'];
              $sql2s = "SELECT Rol_nombre FROM rol WHERE id = {$mostrar['Rol_ID']}";
              $result2s=$MySQLiconn->query($sql2s);
              $rol = mysqli_fetch_array($result2s)['Rol_nombre'];
              
              $id = $mostrar['Tipo_usuario_ID'];
              $sql3s = "SELECT Tipo_usuario_nombre FROM tipo_usuario WHERE id = {$mostrar['Tipo_usuario_ID']}";
              $result3s=$MySQLiconn->query($sql3s);
              $trolu = mysqli_fetch_array($result3s)['Tipo_usuario_nombre'];
              ?>
              <tr class="data-row">
                <td><?php echo $mostrar['id']?></td>
                <td><?php echo $mostrar['username']?></td>
                <td><?php echo $mostrar['email']?></td>
                <td><?php echo $rol ?></td>
                <td><?php echo $trolu ?></td>
                <td><?php echo $mostrar['create_at']?></td>
                <td><?php echo $mostrar['update_at']?></td>
                <td>
                  <a href="update_user.php?id=<?php echo $mostrar['id']?>" onclick="return confirm('¿Deseas Editarlo ?'); ">
                    <span class="glyphicon glyphicon-pencil"></span> 
                  </a>
                </td>
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
</body>
<script src="../JS/searchv2.js"></script>
</html>