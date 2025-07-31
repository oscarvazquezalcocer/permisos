<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include_once 'Db.php';

if (isset($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Selecciona el password_hash, el Rol_ID y el id correspondientes al nombre de usuario dado
    $query = "SELECT password_hash, Rol_ID, area_usuario_id, id FROM usuario WHERE username = '$username'";
    $result = $MySQLiconn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password_hash'];
        $rolID = $row['Rol_ID'];
        $userID = $row['id'];
        $area_usuario_id = $row['area_usuario_id'];

        // Verifica si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($password, $hashed_password)) {
            // Inicia la sesión y almacena el nombre de usuario, el Rol_ID y el ID de usuario en variables de sesión
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['rolID'] = $rolID;
            $_SESSION['userID'] = $userID;
            $_SESSION['area_usuario_id'] = $area_usuario_id;

            // Verifica el Rol_ID antes de redirigir a las páginas correspondientes
            if ($rolID == 23) {
                // Redirecciona a la página de administrador solo si el Rol_ID es 23
                header("Location: ../ROL_AD/inicio_Ad.php?$username");
            } elseif ($rolID == 22) {
                // Redirecciona a la página de Jefes solo si el Rol_ID es 22
                header("Location: ../ROL2/Inicio2.php?$username");
            } elseif ($rolID == 24) {
                // Redirecciona a la página de recursos humanos solo si el Rol_ID es 24
                header("Location: ../ROL3/Inicio3.php?$username");
            } elseif ($rolID == 21) {
                // Redirecciona a la página de personal solo si el Rol_ID es 21
                header("Location: ../ROL1/Inicio.php?$username");
            } elseif ($rolID == 25) {
                // Redirecciona a la página de inactivo solo si el Rol_ID es 25
                header("Location: ../ROL_IN/inicio_inactivo.php?$username");
            } else {
                // Redirecciona a una página predeterminada en caso de un Rol_ID desconocido
                header("Location: ../ROL1/Inicio.php?$username");
            }
            exit(); // Detiene la ejecución del script después de la redirección
        } else {
            // La contraseña ingresada no coincide con el hash almacenado
            echo '<script>alert("Datos de Usuario Incorrectos !Intente de nuevo"); window.location.href = "../index.php";</script>';
        }
    } else {
        // No se encontró ningún usuario coincidente
        echo '<script>alert("Datos de Usuario Incorrectos !Intente de nuevo"); window.location.href = "../index.php";</script>';
    }
}
?>