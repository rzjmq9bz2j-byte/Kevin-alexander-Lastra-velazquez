<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM consultas WHERE id_consulta='$id'";

    if ($conexion->query($sql)) {
        header("Location: consulta.php?eliminado=1");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}
?>
