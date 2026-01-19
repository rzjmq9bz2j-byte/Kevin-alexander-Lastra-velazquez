<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM historial_andrologico WHERE id_andro='$id'";

    if ($conexion->query($sql)) {
        header("Location: historial_andrologico.php?eliminado=1");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}
?>
