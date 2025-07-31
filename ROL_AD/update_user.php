<?php
include_once '../DB/Db.php';
session_start();


//se muestran datos

if(empty($_GET['id']))
{
    header('location:usuarios.php');
}

    $res = $MySQLiconn->query("SELECT * FROM usuario");
    while ($row = $res->fetch_array()) 


    //consulta extraccion
$id=$_GET['id'];
$bsu="SELECT * FROM usuario WHERE id='$id'";
$modific=$MySQLiconn->query($bsu);
$dats=$modific->fetch_array();


if(isset($_POST['Actualizar'])){
  //req modif
  $id=$_POST['id'];
  $usn=$MySQLiconn->real_escape_string($_POST['nombre']);
  $em=$MySQLiconn->real_escape_string($_POST['email']);
  $rl=$MySQLiconn->real_escape_string($_POST['puesto']);
  $tu=$MySQLiconn->real_escape_string($_POST['area']);
  //cons modif
  $act="UPDATE usuario SET username='$usn', email='$em', Rol_ID='$rl', Tipo_usuario_ID='$tu' WHERE id ='$id'";
  $actu=$MySQLiconn->query($act);
  header("location:usuarios.php");
}
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
            

        <section class="center-container">
        <div id="texto-derecha">
        <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href = 'usuarios.php';"></button>
        </div>
            <div>
                <h2>Actualizacion de Usuario</h2>
                <hr class="border border-primary border-3 opacity-65">
            </div>
            <br>
            <br> 
            <div id="texto-izquierda" class="container">

            <form class="form-label" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

                <div class="row">
                  <div class="col">
                    <label>Username</label>
                    <input type="hidden" name="id" value="<?php echo $dats['id'];?>">
                    <input class="form-control form-control-lg" type="text" placeholder="Ej. Angel Eduardo" name="nombre" value="<?php echo $dats['username'];?>" aria-label=".form-control-lg example" 
                      required>
                  </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                      <label>EMAIL</label>
                      <input class="form-control form-control-lg" type="text" placeholder="name@example.com" name="email" value="<?php echo $dats['email'];?>" aria-label=".form-control-lg example"
                      required>
                    </div>
                  </div>
                  <br>
                <br>
                <div class="row">
                    <div class="col">
                      <label>Rol_ID</label>
                      <select class="form-select form-select-lg mb-3" name="puesto" required>
                        <option value="">Seleccione una Opción</option>
                        <option value="21">Personal</option>
                        <option value="22">Jefe</option>
                        <option value="23">Administrador</option>
                        <option value="24">Recursos_Humanos</option>
                        <option value="25">Inactivo</option>
                        </select>
                    </div>
                  </div>
                  <br>
                  <br>
                <div class="row">
                    <div class="col">
                      <label>Tipo de usuario ID</label>
                      <select class="form-select form-select-lg mb-3" name="area" required>
                        <option value="">Seleccione una Opción</option>
                        <option value="15">Docente</option>
                        <option value="16">No Docente</option>
                        </select>
                    </div>
                  </div>
                  <br>

                <div id="texto-centrar" class="row">
                  <input type="submit"  name="Actualizar" title="Actualizar" value="Actualizar" class="btn btn-primary">
                </div>
            </form>
            </div>
    </section>

    </body>
</html>