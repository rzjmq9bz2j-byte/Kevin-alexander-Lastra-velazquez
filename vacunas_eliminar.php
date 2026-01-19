<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM vacunas_estudios WHERE id_registro = '$id'";

if ($conexion->query($sql)) {
    header("Location: vacunas.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
