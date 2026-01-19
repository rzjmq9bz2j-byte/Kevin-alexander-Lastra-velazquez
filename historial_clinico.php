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
// GUARDAR HISTORIAL CLÍNICO
// ===============================
if (
    isset($_POST['guardar']) &&
    !empty($_POST['id_paciente']) &&
    !empty($_POST['grupo_sanginio']) &&
    !empty($_POST['alergias']) &&
    !empty($_POST['enfermedades_cronicas']) &&
    !empty($_POST['cirugías']) &&
    !empty($_POST['antecedentes_familiares']) &&
    !empty($_POST['madicamentos_actuales'])
) {

    $id_paciente               = $_POST['id_paciente'];
    $grupo_sanginio            = $_POST['grupo_sanginio'];
    $alergias                  = $_POST['alergias'];
    $enfermedades_cronicas     = $_POST['enfermedades_cronicas'];
    $cirugías                  = $_POST['cirugías'];
    $antecedentes_familiares   = $_POST['antecedentes_familiares'];
    $madicamentos_actuales     = $_POST['madicamentos_actuales'];
    $notas                     = $_POST['notas'];

    $sql = "INSERT INTO historial_clinico (
                id_paciente,
                grupo_sanginio,
                alergias,
                enfermedades_cronicas,
                `cirugías`,
                antecedentes_familiares,
                madicamentos_actuales,
                notas
            ) VALUES (
                '$id_paciente',
                '$grupo_sanginio',
                '$alergias',
                '$enfermedades_cronicas',
                '$cirugías',
                '$antecedentes_familiares',
                '$madicamentos_actuales',
                '$notas'
            )";

    if ($conexion->query($sql)) {
        header("Location: historial_clinico.php");
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
<title>Historial Clínico</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>
<?php if (isset($_GET['eliminado'])): ?>
<p class="mensaje-exito">Historial clínico eliminado</p>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
<p class="mensaje-exito">Historial clínico actualizado</p>
<?php endif; ?>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>HISTORIAL CLÍNICO</h1>
    
</header>

<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>

<h2>Registrar historial clínico</h2><BR>

<form action="historial_clinico.php" method="POST">

<label>Paciente:</label>
<select name="id_paciente" required>
    <option value="">Seleccione...</option>
    <?php while ($p = $pacientes->fetch_assoc()) { ?>
        <option value="<?= $p['id_paciente'] ?>">
            <?= $p['id_paciente'] . " - " . $p['nombre'] ?>
        </option>
    <?php } ?>
</select>

<label>Grupo sanguíneo:</label>
<select name="grupo_sanginio" required>
    <option value="">Seleccione...</option>
    <option value="A+">A+</option>
    <option value="A-">A-</option>
    <option value="B+">B+</option>
    <option value="B-">B-</option>
    <option value="AB+">AB+</option>
    <option value="AB-">AB-</option>
    <option value="O+">O+</option>
    <option value="O-">O-</option>
</select>


<label>Alergias:</label>
<input type="text" name="alergias" required>

<label>Enfermedades crónicas:</label>
<input type="text" name="enfermedades_cronicas" required>

<label>Cirugías:</label>
<input type="text" name="cirugías" required>

<label>Antecedentes familiares:</label>
<input type="text" name="antecedentes_familiares" required>

<label>Medicamentos actuales:</label>
<input type="text" name="madicamentos_actuales" required>

<label>notas:</label>
<input type="text" name="notas" required>

<button type="submit" name="guardar">Guardar</button>

</form><BR>

<h2>Lista de historial clínico</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Grupo</th>
    <th>Alergias</th>
    <th>Crónicas</th>
    <th>Cirugías</th>
    <th>Antecedentes</th>
    <th>Medicamentos</th>
    <th>Notas</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM historial_clinico");
while ($fila = $consulta->fetch_assoc()) {
?>
<tr>
    <td><?= $fila['id_historial'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['grupo_sanginio'] ?></td>
    <td><?= $fila['alergias'] ?></td>
    <td><?= $fila['enfermedades_cronicas'] ?></td>
    <td><?= $fila['cirugías'] ?></td>
    <td><?= $fila['antecedentes_familiares'] ?></td>
    <td><?= $fila['madicamentos_actuales'] ?></td>
    <td><?= $fila['notas'] ?></td>
   <td>
     <button><a href="historial_clinico_editar.php?id=<?= $fila['id_historial'] ?>" class="btn">Editar</a> </button>
    <button onclick="confirmarEliminar(<?= $fila['id_historial'] ?>)">Eliminar</button>
</td>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar historial clínico?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "historial_clinico_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>

</tr>
<?php } ?>
</tbody>
</table>

</body>
</html>
