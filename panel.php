<?php
session_start();

if (!isset($_SESSION["token"])) {
    header("Location: login.php"); // o index.html, como lo llames
    exit();
}

echo "Bienvenido, " . htmlspecialchars($_SESSION["usuario"]);
