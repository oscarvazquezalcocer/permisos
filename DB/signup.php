<?php
include_once 'Db.php';

// Define la función buscarrep para ver si no hay dato repetido 
function buscarrep($username, $email, $MySQLiconn) {
    $sql = "SELECT * FROM usuario WHERE username='$username' OR email='$email'";
    $result = mysqli_query($MySQLiconn, $sql);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['sexo']) && isset($_POST['puesto']) && isset($_POST['area']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['puestoa']) && isset($_POST['tipoa'])&& isset($_POST['areaU'])) {
    // Obtener y limpiar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $puesto = $_POST['puesto'];
    $area = $_POST['area'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rl = $_POST['puestoa'];
    $tu = $_POST['tipoa'];
    $au=$_POST['areaU'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Verificar si ya existe un usuario o correo electrónico
if (buscarrep($username, $email, $MySQLiconn)) {
    $response = array("status" => "error", "message" => "Este usuario ya existe");
} else {
    // Insertar datos en la tabla 'usuario'
    $sql = "INSERT INTO usuario (username, email, password_hash, ROL_ID, Tipo_usuario_ID, area_usuario_id) VALUES ('$username', '$email', '$hashed_password', '$rl', '$tu', '$au')";
    if ($MySQLiconn->query($sql)) {
        $usuarioID = $MySQLiconn->insert_id;
        
        // Insertar datos en la tabla 'perfil'
        $sql = "INSERT INTO perfil (nombre, apellido, sexo, area, puesto, User_ID) VALUES ('$nombre', '$apellido', '$sexo', '$area', '$puesto', '$usuarioID')";
        if ($MySQLiconn->query($sql)) {
            $response = array("status" => "success", "message" => "Registro exitoso");
        } else {
            $response = array("status" => "error", "message" => "Error al insertar datos en la tabla 'perfil': " . $MySQLiconn->error);
        }
    } else {
        $response = array("status" => "error", "message" => "Error al insertar datos en la tabla 'usuario': " . $MySQLiconn->error);
    }
}

echo json_encode($response);

$MySQLiconn->close();
}
?>