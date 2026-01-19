<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

/* GUARDAR CAMBIOS */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "UPDATE medicos SET
        nombre = '$nombre',
        especialidad = '$especialidad',
        telefono = '$telefono',
        correo = '$correo'
        WHERE id_medico = '$id'
    ";

    if ($conexion->query($sql)) {
        header("Location: medicos.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR DATOS */
$consulta = $conexion->query("SELECT * FROM medicos WHERE id_medico = '$id'");
$datos = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Médico</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<h2>Editar Médico</h2>

<form method="POST" class="form-card">

  <label>Nombre:</label>
  <input type="text" name="nombre" value="<?= $datos['nombre'] ?>" required>

  <label>Especialidad:</label>
  <input type="text" name="especialidad" value="<?= $datos['especialidad'] ?>" required>

  <label>Teléfono:</label>
  <input type="number" name="telefono" value="<?= $datos['telefono'] ?>" required>

  <label>Correo:</label>
  <input type="email" name="correo" value="<?= $datos['correo'] ?>" required>

  <button type="submit">Guardar cambios</button>

</form>

</body>
</html>
