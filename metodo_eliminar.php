<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

$sql = "DELETE FROM metidos_anticonceptivos WHERE id_metodo = '$id'";

if ($conexion->query($sql)) {
    header("Location: metodos.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
