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
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $curp = $_POST['curp'];
    $fecha = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE pacientes SET
        nombre = '$nombre',
        apellido_paterno = '$apellido_paterno',
        apellido_materno = '$apellido_materno',
        curp = '$curp',
        fecha_nacimiento = '$fecha',
        genero = '$genero',
        telefono = '$telefono',
        direccion = '$direccion'
        WHERE id_paciente = '$id'
    ";

    if ($conexion->query($sql)) {
        header("Location: pacientes.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR DATOS */
$consulta = $conexion->query("SELECT * FROM pacientes WHERE id_paciente = '$id'");
$paciente = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Paciente</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<h2>Editar Paciente</h2>

<form method="POST">

<label>Nombre:</label>
<input type="text" name="nombre" value="<?= $paciente['nombre'] ?>" required>

<label>Apellido Paterno:</label>
<input type="text" name="apellido_paterno" value="<?= $paciente['apellido_paterno'] ?>" required>

<label>Apellido Materno:</label>
<input type="text" name="apellido_materno" value="<?= $paciente['apellido_materno'] ?>" required>

<label>CURP:</label>
<input type="text" name="curp" value="<?= $paciente['curp'] ?>" required>

<label>Fecha de nacimiento:</label>
<input type="date" name="fecha_nacimiento" value="<?= $paciente['fecha_nacimiento'] ?>" required>

<label>Género:</label>
<select name="genero" required>
    <option value="Masculino" <?= $paciente['genero']=='Masculino'?'selected':'' ?>>Masculino</option>
    <option value="Femenino" <?= $paciente['genero']=='Femenino'?'selected':'' ?>>Femenino</option>
    <option value="Otro" <?= $paciente['genero']=='Otro'?'selected':'' ?>>Otro</option>
</select>

<label>Teléfono:</label>
<input type="text" name="telefono" value="<?= $paciente['telefono'] ?>" required>

<label>Dirección:</label>
<input type="text" name="direccion" value="<?= $paciente['direccion'] ?>" required>

<button type="submit">Guardar cambios</button>


</form>

</body>
</html>
