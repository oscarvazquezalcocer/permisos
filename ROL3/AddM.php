<?php
include_once '../DB/Db.php';
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title> Motivo Nuevo</title>
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

  <header id="barra" class="text-white">
    GESTOR DE PERMISOS WEB (GPW)
    <img src="../IMG/LogoTecNMBlanco.png" class="log1">
    <img src="../IMG/LogIts.png" class="log2">
    <div class="rectangulo1"></div>
    <div class="rectangulo2"></div>
  </header>


  <section class="center-container">
    <div class="align-middle">
      <div id="texto-derecha">
        <button type="button" class="btn-close btn-lg" aria-label="Close"
          onclick="window.location.href = 'motivo.php'"></button>
      </div>
      <div>
      </div>
      <h2>AGREGAR MOTIVO</h2>
      <hr class="border border-primary border-3 opacity-65">
    </div>
    <br>
    <br>
    <div id="texto-izquierda" class="container">

      <form class="form-label" action="" method="Post">

        <div class="row">
          <div class="col">
            <label>MOTIVO</label>
            <input class="form-control form-control-lg" type="text" placeholder="Escribe un nuevo motivo"
              name="Motivo_nombre" aria-label=".form-control-lg example" required>
          </div>
          <div class="col">
            <label>VALOR</label>
            <input class="form-control form-control-lg" type="text" placeholder=" # Digita el valor de dicho Motivo"
              name="Motivo_valor" aria-label=".form-control-lg example" required>
          </div>
        </div>
        <br>

        <div id="texto-centrar">
          <input type="submit" title="Add" value="Add" class="btn btn-primary btn-lg">
        </div>
      </form>
    </div>
  </section>

  <?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $MotivoNombre = $MySQLiconn->real_escape_string($_POST['Motivo_nombre']);
    $Valor = $MySQLiconn->real_escape_string($_POST['Motivo_valor']);

    // Insertar datos en la tabla 
    $sql = "INSERT INTO motivo (Motivo_nombre, Motivo_valor) VALUES ('$MotivoNombre', '$Valor')";

    if ($MySQLiconn->query($sql)) {
      $mensaje = "¡Registro exitoso!";
      $mensaje = urlencode($mensaje);
      $redirectURL = "motivo.php?msg=" . $mensaje;

      // Redirige al usuario a la otra página
      header("Location: " . $redirectURL);
      exit; // Agregamos 'exit' para detener la ejecución después de la redirección
    } else {
      echo "Error al insertar datos en la tabla 'motivo': " . $MySQLiconn->error;
    }
  }

  $MySQLiconn->close();
  ?>

</body>

</html>