<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM medicos WHERE id_medico = '$id'";

if ($conexion->query($sql)) {
    header("Location: medicos.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
