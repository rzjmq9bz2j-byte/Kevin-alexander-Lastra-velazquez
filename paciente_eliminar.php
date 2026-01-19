<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM pacientes WHERE id_paciente = '$id'";

if ($conexion->query($sql)) {
    header("Location: pacientes.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
