<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM historial_clinico WHERE id_historial='$id'";

    if ($conexion->query($sql)) {
        header("Location: historial_clinico.php?eliminado=1");
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>
