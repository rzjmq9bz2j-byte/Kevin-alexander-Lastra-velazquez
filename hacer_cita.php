<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===============================
// CARGAR PACIENTES
// ===============================
$pacientes = $conexion->query("SELECT id_paciente, nombre FROM pacientes");
if (!$pacientes) {
    die("Error cargando pacientes: " . $conexion->error);
}

// ===============================
// CARGAR MÉDICOS
// ===============================
$medicos = $conexion->query("SELECT id_medico, nombre FROM medicos");
if (!$medicos) {
    die("Error cargando médicos: " . $conexion->error);
}

// ===============================
// GUARDAR CITA
// ===============================
if (
    isset($_POST['guardar']) &&
    !empty($_POST['id_paciente']) &&
    !empty($_POST['id_medico']) &&
    !empty($_POST['fecha']) &&
    !empty($_POST['hora']) &&
    !empty($_POST['motivo']) &&
    !empty($_POST['estado'])
) {

    $id_paciente      = $_POST['id_paciente'];
    $id_medico        = $_POST['id_medico'];
    $fecha            = $_POST['fecha'];
    $hora             = $_POST['hora'];
    $motivo           = $_POST['motivo'];
    $estado           = $_POST['estado'];
    $recordatorio_en  = !empty($_POST['recordatorio_en']) ? $_POST['recordatorio_en'] : NULL;

    $sql = "INSERT INTO citas 
            (id_paciente, id_medico, fecha, hora, motivo, estado, recordatorio_en)
            VALUES 
            ('$id_paciente', '$id_medico', '$fecha', '$hora', '$motivo', '$estado', '$recordatorio_en')";

    if ($conexion->query($sql)) {
        header("Location: hacer_cita.php");
        exit;
    } else {
        echo "Error al guardar: " . $conexion->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>hacer cita</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>HACER CITA</h1>
</header>






<h2>Llena el formulario</h2><BR>

<form action="buscar_paciente.php" method="POST">

<label>Paciente:</label>
<select name="id_paciente" required>
    <option value="">Seleccione...</option>
    <?php while ($p = $pacientes->fetch_assoc()) { ?>
        <option value="<?= $p['id_paciente'] ?>">
            <?= $p['id_paciente'] . " - " . $p['nombre'] ?>
        </option>
    <?php } ?>
</select>

<label>Médico:</label>
<select name="id_medico" required>
    <option value="">Seleccione...</option>
    <?php while ($m = $medicos->fetch_assoc()) { ?>
        <option value="<?= $m['id_medico'] ?>">
            <?= $m['id_medico'] . " - " . $m['nombre'] ?>
        </option>
    <?php } ?>
</select>

<label>Fecha:</label>
<input type="date" name="fecha" required>

<label>Hora:</label>
<input type="time" name="hora" required>

<label>Motivo:</label>
<input type="text" name="motivo" required>

<label>Estado:</label>
<select name="estado" required>
    <option value="">Seleccionar...</option>
    <option value="pendiente">Pendiente</option>
    <option value="confirmada">Confirmada</option>
    <option value="realizada">Realizada</option>
    <option value="cancelada">Cancelada</option>
</select>

<label>Recordatorio:</label>
<input type="datetime-local" name="recordatorio_en">

<button type="submit" name="guardar">Guardar</button>


</form>
    </body>
</html>    