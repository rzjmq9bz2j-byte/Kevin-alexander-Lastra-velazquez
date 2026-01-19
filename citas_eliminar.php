<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM citas WHERE id_cita='$id'";

    if ($conexion->query($sql)) {
        header("Location: citas.php?eliminado=1");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}
?>
