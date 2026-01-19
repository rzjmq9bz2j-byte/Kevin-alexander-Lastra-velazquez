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
        header("Location: citas.php");
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
<title>Citas</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>
<?php if (isset($_GET['eliminado'])): ?>
<p class="mensaje-exito">✅ Cita eliminada</p>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
<p class="mensaje-exito">✏️ Cita actualizada</p>
<?php endif; ?>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>CITAS</h1>
</header>

<nav>
    <ul>
        <li><a href="admin01.html">Inicio</a></li>
    </ul>
</nav>

<h2>Registrar Cita</h2><BR>

<form action="citas.php" method="POST">

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


</form><BR>

<h2>Lista de Citas</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Médico</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Motivo</th>
    <th>Estado</th>
    <th>Recordatorio</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM citas");
while ($fila = $consulta->fetch_assoc()) {
?>
<tr>
    <td><?= $fila['id_cita'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['id_medico'] ?></td>
    <td><?= $fila['fecha'] ?></td>
    <td><?= $fila['hora'] ?></td>
    <td><?= $fila['motivo'] ?></td>
    <td><?= $fila['estado'] ?></td>
    <td><?= $fila['recordatorio_en'] ?></td>
    <td>
        
    <button> <a href="citas_editar.php?id=<?= $fila['id_cita'] ?>" class="btn">Editar</a> </button>
    <button onclick="confirmarEliminar(<?= $fila['id_cita'] ?>)">Eliminar</button>
</td>

    
</tr>
<?php } ?>
</tbody>
</table>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:300px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar esta cita?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "citas_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>

</body>
</html>
