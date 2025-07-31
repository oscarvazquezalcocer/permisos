<?php
session_start();
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Inicio Administrador Inactivo</title>
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
                  <li id="hov" class="nav-item"><a class="nav-link active" aria-current="page" href="inicio_inactivo.php">Inicio</a></li>
              </ul>
              <ul class="navbar-nav navbar-right">
                  <li class="nav-item"><a class="nav-link" href="perfil_Ad.html">Configurar Perfil</a></li>
                  <li>
                      <form action="../DB/logout.php" method="POST">
                          <button type="submit" class="btn btn-secondary">
                              <span class="glyphicon glyphicon-log-out"></span> &nbsp;
                              Cerrar Sesión
                          </button>
                      </form>
                  </li>
              </ul>
          </div>
      </div>
  </nav>   
  
  <section class="center-container">
  <h2>Información de Usuario</h2>
        <br>
        <h3>Cuenta Inactiva Contacta un Administrador</h3>
      <div>
          <?php
          include_once '../DB/Db.php';
  
          // Verificar si el nombre de usuario está presente en la sesión
          if (isset($_SESSION['username'])) {
              $username = $_SESSION['username'];
  
              // Realizar una consulta con JOIN para obtener los datos de usuario y perfil
              $query = "SELECT usuario.username, perfil.nombre, perfil.puesto, perfil.area
                        FROM usuario
                        JOIN perfil ON usuario.id = perfil.User_ID
                        WHERE usuario.username = '$username'";
              $result = $MySQLiconn->query($query);
  
              if ($result->num_rows == 1) {
                  // Obtener los datos del usuario y perfil desde el resultado de la consulta
                  $row = $result->fetch_assoc();
                  $nombre = $row['nombre'];
                  $puesto = $row['puesto'];
                  $area = $row['area'];
  
                  // Mostrar los datos del usuario en el HTML
                  echo '<br>';
                  echo '<p>Username: ' . $username . '</p>';
                  echo '<p>Nombre: ' . $nombre . '</p>';
                  echo '<p>Puesto: ' . $puesto . '</p>';
                  echo '<p>Area de Adscripcion: ' . $area . '</p>';
              } else {
                  echo 'No se encontró un usuario con el nombre de usuario proporcionado';
              }
          } else {
                echo 'El nombre de usuario no está presente en la sesión';
          }
          ?>
      </div>
    
  </section>

  <footer class="sfooter">
    <div id="texto-centrar" class="text-white">
      <h6>Gestor de Permisos Web @</h6>
    </div>
  </footer>

</body>

</html>