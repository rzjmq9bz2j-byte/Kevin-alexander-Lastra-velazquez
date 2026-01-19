<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM documentospacientes WHERE id_documentos='$id'";

    if ($conexion->query($sql)) {
        header("Location: documentos_personas.php?eliminado=1");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}
?>
