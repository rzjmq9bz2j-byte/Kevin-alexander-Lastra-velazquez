<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM usuario WHERE id_usuario = '$id'";

if ($conexion->query($sql)) {
    header("Location: usuario.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
