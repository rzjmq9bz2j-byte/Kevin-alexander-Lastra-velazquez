<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===============================
// CARGAR CITAS
// ===============================
$citas = $conexion->query("SELECT id_cita FROM citas");
if (!$citas) {
    die("Error cargando citas: " . $conexion->error);
}

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
// GUARDAR CONSULTA
// ===============================
if (isset($_POST['guardar'])) {

    $id_cita           = $_POST['id_cita'];
    $id_paciente       = $_POST['id_paciente'];
    $id_medico         = $_POST['id_medico'];
    $fecha             = $_POST['fecha'];
    $motivo_consulta   = $_POST['motivo_consulta'];
    $signos_vitales    = $_POST['signos_vitales'];
    $examen_fisico     = $_POST['examen_fisico'];
    $diagnostico       = $_POST['diagnostico'];
    $tratamiento       = $_POST['tratamiento'];
    $receta            = $_POST['receta'];
    $recomendaciones   = $_POST['recomendaciones'];

    $sql = "INSERT INTO consultas (
                id_cita,
                id_paciente,
                id_medico,
                fecha,
                motivo_consulta,
                signos_vitales,
                examen_fisico,
                diagnostico,
                tratamiento,
                receta,
                recomendaciones
            ) VALUES (
                '$id_cita',
                '$id_paciente',
                '$id_medico',
                '$fecha',
                '$motivo_consulta',
                '$signos_vitales',
                '$examen_fisico',
                '$diagnostico',
                '$tratamiento',
                '$receta',
                '$recomendaciones'
            )";

    if ($conexion->query($sql)) {
        echo "<script>
                alert('Consulta realizada con éxito');
                window.location='inicio.html';
              </script>";
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
<title>Consulta</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<header>
    <div class="logo-box">
        <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
    </div>
    <h1>CONSULTA</h1>
</header>

<nav>
    <ul>
        <li><a href="inicio.html">Inicio</a></li>
    </ul>
</nav>

<h2>Registrar Consulta</h2><br>

<form method="POST">

<label>Cita:</label>
<select name="id_cita" required>
    <option value="">Seleccione...</option>
    <?php while ($c = $citas->fetch_assoc()) { ?>
        <option value="<?= $c['id_cita'] ?>"><?= $c['id_cita'] ?></option>
    <?php } ?>
</select>

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
<input type="datetime-local" name="fecha" required>

<label>Motivo de consulta:</label>
<input type="text" name="motivo_consulta" required>

<label>Signos vitales:</label>
<input type="text" name="signos_vitales" required>

<label>Examen físico:</label>
<input type="text" name="examen_fisico" required>

<label>Diagnóstico:</label>
<input type="text" name="diagnostico" required>

<label>Tratamiento:</label>
<input type="text" name="tratamiento" required>

<label>Receta:</label>
<input type="text" name="receta" required>

<label>Recomendaciones:</label>
<input type="text" name="recomendaciones" required>

<button type="submit" name="guardar">Guardar</button>

</form>

</body>
</html>
