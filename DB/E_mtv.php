<?php
include_once 'Db.php';

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $delete = "DELETE FROM motivo WHERE ID = '$id'";
    $result = $MySQLiconn->query($delete);

    if ($result) {
        header("Location: ../ROL_AD/motivo.php");
        exit();
    } else {
        echo "Error al eliminar datos en la tabla 'motivo': " . $MySQLiconn->error;
    }
} else {
    echo "ID no proporcionado.";
}
?>