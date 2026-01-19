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
        header("Location: consulta.php");
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
<title>Consulta </title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>
<?php if (isset($_GET['eliminado'])): ?>
<p class="mensaje-exito">✅ Consulta eliminada</p>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
<p class="mensaje-exito">✏️ Consulta actualizada</p>
<?php endif; ?>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>CONSULTA </h1>
</header>

<nav>
    <ul>
        <li><a href="admin01.html">Inicio</a></li>
    </ul>
</nav>

<h2>Registrar Consulta</h2><BR>

<form action="consulta.php" method="POST">

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

</form><BR>

<h2>Historial de Consultas</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Cita</th>
    <th>Paciente</th>
    <th>Médico</th>
    <th>Fecha</th>
    <th>Motivo</th>
    <th>Signos vitales</th>
    <th>Examen físico</th>
    <th>Diagnóstico</th>
    <th>Tratamiento</th>
    <th>Receta</th>
    <th>Recomendaciones</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$lista = $conexion->query("SELECT * FROM consultas");
while ($fila = $lista->fetch_assoc()) {
?>
<tr>
    <td><?= $fila['id_consulta'] ?></td>
    <td><?= $fila['id_cita'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['id_medico'] ?></td>
    <td><?= $fila['fecha'] ?></td>
    <td><?= $fila['motivo_consulta'] ?></td>
    <td><?= $fila['signos_vitales'] ?></td>
    <td><?= $fila['examen_fisico'] ?></td>
    <td><?= $fila['diagnostico'] ?></td>
    <td><?= $fila['tratamiento'] ?></td>
    <td><?= $fila['receta'] ?></td>
    <td><?= $fila['recomendaciones'] ?></td>
    <td>
    <button> <a href="consulta_editar.php?id=<?= $fila['id_consulta'] ?>" class="btn">Editar</a> </button>
    <button onclick="confirmarEliminar(<?= $fila['id_consulta'] ?>)">Eliminar</button>
</td>

</tr>
<?php } ?>
</tbody>
</table>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar esta consulta?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "consulta_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>

</body>
</html>
