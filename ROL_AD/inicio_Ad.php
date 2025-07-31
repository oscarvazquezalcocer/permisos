<?php
include_once '../DB/Db.php';
session_start();
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title> Inicio_Ad </title>
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
  <style>
      #mg {
          border-radius: 50%;  
          box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
      }

      .tback{
       background-image: url('../IMG/ftest.jpg'); 
       background-size: cover; 
       /* background-color: #002244; eliminar pa volver a color */
        height: 295px;
        width:1000;
        margin-left: -48px;
        margin-right: -48px;
        margin-top: -48px;
        position: relative;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px; 
}
      h3 {
            color:  #ffffff;
            
        }

        h2 {
            color:  #ffffff;
        }

    </style>
</head>

<body id="texto-normal" onload="noBack();">

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
                  <li id="hov" class="nav-item"><a class="nav-link active" aria-current="page" href="inicio_Ad.php">Inicio</a></li>
                  <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
                  <li class="nav-item"><a class="nav-link" href="datosuser.php">Datos de Usuarios</a></li>
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
  <section class="center-container">
  <div class="tback">
  <br>
  <h2>Información de Usuario</h2>
        <br>
        <h3 >ADMINISTRADOR</h3>
        <img id="mg" src="../IMG/user.png" alt="Icono user" width="200" height="200">    
  </div>
        <div>
      <?php
// Verificar si el nombre de usuario está presente en la sesión
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  // Realizar una consulta con JOIN para obtener los datos de usuario y perfil
  $query = "SELECT usuario.username, perfil.nombre, perfil.apellido, perfil.puesto, perfil.area
                FROM usuario
                JOIN perfil ON usuario.id = perfil.User_ID
                WHERE usuario.username = '$username'";
  $result = $MySQLiconn->query($query);

  if ($result->num_rows == 1) {
    // Obtener los datos del usuario y perfil desde el resultado de la consulta
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $puesto = $row['puesto'];
    $area = $row['area'];

    // Mostrar los datos del usuario en el HTML
    echo '<br>';
echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Usuario:</b><br> ' . $username . '</p>';
echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Nombre:</b><br> ' . $nombre . ' ' . $apellido . '</p>';
echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Puesto:</b><br> ' . $puesto . '</p>';
echo '<p style="font-family: Arial, sans-serif; font-size: 15px;"><b>Area de Adscripcion:</b><br> ' . $area . '</p>';
  } else {
    echo 'No se encontró un usuario con el nombre de usuario proporcionado';
  }
} else {
  echo '<p style="margin-top:48px; font-size: 20px; color: #ff0000;">Inicie sesión para ver los datos correspondientes.</p>';
}
?>
      </div>
    
  </section>

  <footer class="sfooter">
    <div id="texto-centrar" class="text-white">
      <h6>Gestor de Permisos Web @</h6>
    </div>
  </footer>

  <script>
  window.history.forward();
function noBack() { window.history.forward(); }
</script>
</body>

</html>