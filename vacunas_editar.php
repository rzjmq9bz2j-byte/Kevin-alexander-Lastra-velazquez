<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

/* CARGAR PACIENTES */
$pacientes = $conexion->query("SELECT id_paciente, nombre FROM pacientes");

/* CARGAR MÉDICOS */
$medicos = $conexion->query("SELECT id_medico, nombre FROM medicos");

/* ACTUALIZAR */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_paciente = $_POST['id_paciente'];
    $id_medico   = $_POST['id_medico'];
    $tipo        = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha       = $_POST['fecha'];
    $realizado   = $_POST['realizado_por'];
    $resultado   = $_POST['resultado'];
    $archivo     = $_POST['archivo_resultado'];

    $sql = "UPDATE vacunas_estudios SET
        id_paciente='$id_paciente',
        id_medico='$id_medico',
        tipo='$tipo',
        descripcion='$descripcion',
        fecha='$fecha',
        realizado_por='$realizado',
        resultado='$resultado',
        archivo_resultado='$archivo'
        WHERE id_registro='$id'
    ";

    if ($conexion->query($sql)) {
        header("Location: vacunas.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR REGISTRO */
$consulta = $conexion->query("SELECT * FROM vacunas_estudios WHERE id_registro='$id'");
$registro = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Vacuna / Estudio</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar Vacuna / Estudio</h2>

<form method="POST">

<label>Paciente:</label>
<select name="id_paciente" required>
<?php while ($p = $pacientes->fetch_assoc()) { ?>
<option value="<?= $p['id_paciente'] ?>"
<?= $registro['id_paciente']==$p['id_paciente']?'selected':'' ?>>
<?= $p['id_paciente']." - ".$p['nombre'] ?>
</option>
<?php } ?>
</select>

<label>Médico:</label>
<select name="id_medico" id="medicoSelect" required>
<?php while ($m = $medicos->fetch_assoc()) { ?>
<option value="<?= $m['id_medico'] ?>"
<?= $registro['id_medico']==$m['id_medico']?'selected':'' ?>>
<?= $m['id_medico']." - ".$m['nombre'] ?>
</option>
<?php } ?>
</select>

<label>Tipo:</label>
<select name="tipo" required>
<option value="vacuna" <?= $registro['tipo']=="vacuna"?'selected':'' ?>>Vacuna</option>
<option value="popanicolaou" <?= $registro['tipo']=="popanicolaou"?'selected':'' ?>>Papanicolaou</option>
<option value="ultrasonido" <?= $registro['tipo']=="ultrasonido"?'selected':'' ?>>Ultrasonido</option>
<option value="VIH" <?= $registro['tipo']=="VIH"?'selected':'' ?>>VIH</option>
<option value="ETS" <?= $registro['tipo']=="ETS"?'selected':'' ?>>ETS</option>
<option value="OTROS" <?= $registro['tipo']=="OTROS"?'selected':'' ?>>Otros</option>
</select>

<label>Descripción:</label>
<input type="text" name="descripcion" value="<?= $registro['descripcion'] ?>" required>

<label>Fecha:</label>
<input type="date" name="fecha" value="<?= $registro['fecha'] ?>" required>

<label>Realizado por:</label>
<input type="text" name="realizado_por" id="realizado_por" value="<?= $registro['realizado_por'] ?>" required>

<label>Resultado:</label>
<input type="text" name="resultado" value="<?= $registro['resultado'] ?>" required>

<label>Archivo resultado:</label>
<input type="text" name="archivo_resultado" value="<?= $registro['archivo_resultado'] ?>">

<button type="submit">Guardar cambios</button>


</form>

<script>
document.getElementById("medicoSelect").addEventListener("change", function() {
    document.getElementById("realizado_por").value = this.value;
});
</script>

</body>
</html>
