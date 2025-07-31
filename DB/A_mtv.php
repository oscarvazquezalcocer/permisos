<?php
include_once 'Db.php';

if (isset($_POST['mnombre']) && isset($_POST['mvalor'])) {
    $mnombre = $_POST['mnombre'];
    $mvalor = $_POST['mvalor'];

    // Insertar datos en la tabla 'motivo'
    $sql = "INSERT INTO motivo (Motivo_nombre, Motivo_valor) VALUES ('$mnombre', '$mvalor')";
    if ($MySQLiconn->query($sql)) {
        header("Location: ../ROL_AD/motivo.php");
        exit();
    } else {
        echo "Error al insertar datos en la tabla 'motivo': " . $MySQLiconn->error;
    }
}
?>