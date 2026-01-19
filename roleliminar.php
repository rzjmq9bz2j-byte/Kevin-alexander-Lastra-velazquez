<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM roles WHERE id_rol = '$id'";

if ($conexion->query($sql)) {
    header("Location: roles.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
