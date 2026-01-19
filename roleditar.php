<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

/* GUARDAR CAMBIOS */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE roles SET
        nombre = '$nombre',
        descripcion = '$descripcion'
        WHERE id_rol = '$id'
    ";

    if ($conexion->query($sql)) {
        header("Location: roles.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR DATOS */
$consulta = $conexion->query("SELECT * FROM roles WHERE id_rol = '$id'");
$rol = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Rol</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<h2>Editar Rol</h2>

<form method="POST">

<label>Nombre del rol:</label>
<input type="text" name="nombre" value="<?= $rol['nombre'] ?>" required>

<label>Descripción:</label>
<input type="text" name="descripcion" value="<?= $rol['descripcion'] ?>" required>

<button type="submit">Guardar cambios</button>


</form>

</body>
</html>
