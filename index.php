<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!doctype html>
<!-- Representa la raíz de un documento HTML o XHTML. Todos los demás elementos deben ser descendientes de este elemento. -->
<html lang="es">
    
    <head>
        <meta charset="utf-8">
        <title> Login </title>    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="CSS/login.css">    
        <style>

        .password-container {
            display: flex;
            align-items: center;
        }

        .password-toggle {
            position: absolute;
            right: 55px;
            margin-bottom: 8px;
            cursor: pointer;
        }
          /* Estilo para el icono de ojo abierto (verde) */
          .password-toggle i.fa-eye {
            color: blue;
        }

        /* Estilo para el icono de ojo cerrado (rojo) */
        .password-toggle i.fa-eye-slash {
            color: red;
        }
        
    </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link rel="icon" href="IMG/logIts.png" type="image/png">
    </head>
    
    <body>
        
        <div class="cuadrado">      
           <h2>GESTOR DE PERMISOS WEB (GPW) </h2>           
        </div>  
            <div> <img src="IMG/LogoTecNMBlanco.png" class="log1"></div>
            <div id="contenedor">
                <div id="central">
                    <div id="login">
                        <div>
                            <img src="IMG/log2.png" class="log2">
                        </div>
                        <div class="titulo">
                            Bienvenido
                        </div>
                        <form id="loginform" action="DB/Login_C.php" method="Post"> 
                        <input type="text" name="username" placeholder="Usuario" required> 
                    
                            <div class="password-container">
                            <input type="password" name="password" id="password" placeholder="Contraseña" required>
                            <span class="password-toggle" onclick="togglePassword()"> <i class="fas fa-eye"></i> </span>
                            </div>
                            
                            <button type="submit" title="Iniciar Sesion" name="Login">Iniciar Sesion</button>
                        </form>
                        <div class="pie-form">
                            <a href="#">¿Olvidaste tu contraseña?</a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

<script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var passwordToggle = document.querySelector(".password-toggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Icono de ojo cerrado
            } else {
                passwordInput.type = "password";
                passwordToggle.innerHTML = '<i class="fas fa-eye"></i>'; // Icono de ojo abierto
            }
        }
    </script>

<!-- Este fragmento de codigo imprime el mensaje en una ventana emergente si el registro del formulario registro.php
a sido exitoso -->
            <?php
            if (isset($_GET['mensaje'])) {
                $mensaje = $_GET['mensaje'];
                // Mostrar el mensaje en una ventana emergente o en la página
                 echo "<script>alert('" . $mensaje . "');</script>";
                }
                ?>
                  
    </body>
</html>