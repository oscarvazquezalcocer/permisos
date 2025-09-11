<?php

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

if (!$username || !$password) {
    echo "<div style='color:red;'>Usuario o contraseña faltante</div>";
    exit();
}

$ch = curl_init("http://192.168.9.22:8000/auth/login");

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    http_build_query([
        "username" => $username,
        "password" => $password,
    ]),
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded",
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false) {
    echo "<div style='color:red;'>No se pudo contactar con el servidor de autenticación</div>";
    exit();
}

// Decodificar la respuesta JSON
$result = json_decode($response, true);

if ($httpCode === 200 && isset($result["access_token"])) {
    // Inicio de sesión exitoso
    session_start();
    $_SESSION["token"] = $result["access_token"];
    $_SESSION["usuario"] = $result["user"];

    header("HX-Redirect: ../panel.php");
    exit();
} elseif ($httpCode === 400) {
    // Credenciales incorrectas
    echo "<div style='color:red;'>Usuario o contraseña inválidos</div>";
    exit();
} else {
    // Otro error inesperado
    echo "<div style='color:red;'>Error del servidor: Código $httpCode</div>";
    exit();
}
