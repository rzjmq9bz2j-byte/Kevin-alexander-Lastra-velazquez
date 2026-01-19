<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM auditoria WHERE id_log = '$id'";

    if ($conexion->query($sql)) {
        header("Location: auditoria.php?eliminado=1");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}
?>
