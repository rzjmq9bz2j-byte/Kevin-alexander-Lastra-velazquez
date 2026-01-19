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
// GUARDAR HISTORIAL
// ===============================
if (
    isset($_POST['guardar']) &&
    !empty($_POST['id_paciente']) &&
    isset($_POST['problema_fertilidad']) &&
    !empty($_POST['ets_previas']) &&
    !empty($_POST['problemas_prostata']) &&
    !empty($_POST['medicamentos_actulales'])
) {

    $id_paciente            = $_POST['id_paciente'];
    $problema_fertilidad    = $_POST['problema_fertilidad'];
    $ets_previas            = $_POST['ets_previas'];
    $problemas_prostata     = $_POST['problemas_prostata'];
    $medicamentos_actulales  = $_POST['medicamentos_actulales'];
    $notas                  = $_POST['notas'];

    $sql = "INSERT INTO historial_andrologico (
                id_paciente,
                problema_fertilidad,
                ets_previas,
                problemas_prostata,
                medicamentos_actulales,
                notas
            ) VALUES (
                '$id_paciente',
                '$problema_fertilidad',
                '$ets_previas',
                '$problemas_prostata',
                '$medicamentos_actulales',
                '$notas'
            )";

    if ($conexion->query($sql)) {
        header("Location: historial_andrologico.php");
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
<title>Historial Andrológico</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>
<?php if (isset($_GET['eliminado'])): ?>
<p class="mensaje-exito"> Historial eliminado correctamente</p>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
<p class="mensaje-exito"> Historial actualizado correctamente</p>
<?php endif; ?>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>HISTORIAL ANDROLÓGICO</h1>
</header>

<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>

<h2>Registrar historial andrológico</h2><BR>

<form action="historial_andrologico.php" method="POST">

<label>Paciente:</label>
<select name="id_paciente" required>
    <option value="">Seleccione...</option>
    <?php while ($p = $pacientes->fetch_assoc()) { ?>
        <option value="<?= $p['id_paciente'] ?>">
            <?= $p['id_paciente'] . " - " . $p['nombre'] ?>
        </option>
    <?php } ?>
</select>

<label>¿Problema de fertilidad?</label>
<select name="problema_fertilidad" required>
    <option value="">Seleccione...</option>
    <option value="1">Sí</option>
    <option value="0">No</option>
</select>

<label>ETS previas:</label>
<input type="text" name="ets_previas" required>

<label>Problemas de próstata:</label>
<input type="text" name="problemas_prostata" required>

<label>Medicamentos actuales:</label>
<input type="text" name="medicamentos_actulales" required>

<label>Notas:</label>
<input type="text" name="notas">

<button type="submit" name="guardar">Guardar</button>

</form><BR>

<h2>Lista de historial andrológico</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Fertilidad</th>
    <th>ETS previas</th>
    <th>Próstata</th>
    <th>Medicamentos</th>
    <th>Notas</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM historial_andrologico");
while ($fila = $consulta->fetch_assoc()) {
?>
<tr>
    <td><?= $fila['id_andro'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['problema_fertilidad'] ? 'Sí' : 'No' ?></td>
    <td><?= $fila['ets_previas'] ?></td>
    <td><?= $fila['problemas_prostata'] ?></td>
    <td><?= $fila['medicamentos_actulales'] ?></td>
    <td><?= $fila['notas'] ?></td>
  <td>
    <button> <a href="historial_andro_editar.php?id=<?= $fila['id_andro'] ?>" class="btn">Editar</a> </button>
    <button onclick="confirmarEliminar(<?= $fila['id_andro'] ?>)">Eliminar</button>
</td>

</tr>
<?php } ?>
</tbody>
</table>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar historial andrológico?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "historial_andro_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>

</body>
</html>
