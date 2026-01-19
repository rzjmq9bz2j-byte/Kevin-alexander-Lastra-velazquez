<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM historial_Ginecologico WHERE id_gine = '$id'";

if ($conexion->query($sql)) {
    header("Location: historial_Ginecologico.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
