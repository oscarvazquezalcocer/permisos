<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva contraseña</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Restablece tu contraseña de forma segura y rápida. Ingresa una nueva contraseña para continuar con el acceso a tu cuenta.">
    
    <!-- Tailwind CSS v4 Play CDN -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="../CSS/tailwindcss.css">
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Overpass:wght@400;500&display=swap" rel="stylesheet">
    
    <link rel="icon" href="../IMG/logIts.png" type="image/png">
    
    <style>
        body {
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        
        .header-gradient {
            background: linear-gradient(180deg, #0D083B, #1775D6);
        }
        
        .poppins {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen text-white m-0 bg-gray-300">
    
    <!-- Header -->
    <div class="header-gradient w-full h-20 fixed top-0 left-0 flex justify-center items-center z-10">
        <h2 class="text-white text-xl font-medium tracking-wide">GESTOR DE PERMISOS WEB (GPW)</h2>
    </div>
    
    <!-- Logo en el header -->
    <div class="fixed top-1 left-5 z-20">
        <img src="../IMG/LogoTecNMBlanco.png" alt="Logo TecNM" class="h-16 w-auto">
    </div>
    
    <!-- Contenedor principal -->
    <div class="flex items-center justify-center min-h-screen pt-20 px-4">
        <div class="w-full max-w-lg relative">
            
            <!-- Formulario de login -->
            <div class="bg-white rounded-3xl shadow-lg p-8 relative">
                
                <!-- Logos superiores -->
                <div class="flex justify-center items-center mb-6 relative -top-2 -left-8 ">
                    <div class="flex items-center space-x-4">
                        <!-- Logo circular principal -->
                        <img src="../IMG/log2.png" alt="Logo institucional" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <!-- Título -->
                <div class="text-center mb-6">
                    <h1 class="poppins text-2xl font-medium text-gray-800">
                        Restablecer Contraseña
                    </h1>
                </div>
                    
                <span class="text-gray-800 text-sm">
                    Ingrese una nueva contraseña segura, asegurándose de que sea fácil de recordar pero difícil de adivinar.
                </span>

                <!-- Formulario -->
                <form id="loginform" action="../DB/nueva_contrasena.php" method="POST" class="space-y-4 mt-4">
                    
                    <!-- obtener datos del url -->
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">

                    <!-- Campo contrasena -->
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">
                            Nueva Contraseña
                        </label>
                        <input 
                            type="password"
                            id="nueva_contrasena" 
                            name="nueva_contrasena" 
                            placeholder="Ingrese su nueva contraseña" 
                            required
                            minlength="8"
                            autofocus
                            class="w-full h-12 px-6 bg-gray-200 text-gray-800 rounded-xl border-none outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-600 text-lg"
                        />
                        <small class="text-gray-500">Mínimo 8 caracteres.</small>
                    </div>
                    
                    <!-- Botón de login -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            name="Login"
                            class="w-full h-12 bg-blue-700 hover:bg-blue-500 text-white font-medium text-lg rounded-xl transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Restablecer
                        </button>
                    </div>
                </form>
                
                <!-- Enlace para regresar al login -->
                <div class="text-right mt-4">
                    <a 
                        href="../index.php" 
                        class="text-blue-600 text-sm hover:text-blue-800 transition-colors duration-200 no-underline font-medium"
                    >
                        Regresar al Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Manejo de mensajes PHP -->
    <?php
    if (isset($_GET['mensaje'])) {
        $mensaje = $_GET['mensaje'];
        echo "<script>alert('" . htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') . "');</script>";
    }
    ?>
    
</body>
</html>
