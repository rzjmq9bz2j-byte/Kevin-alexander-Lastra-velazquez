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
// CARGAR CONSULTAS
// ===============================
$consultas = $conexion->query("SELECT id_consulta FROM consultas");
if (!$consultas) {
    die("Error cargando consultas: " . $conexion->error);
}

// ===============================
// GUARDAR REGISTRO
// ===============================
if (
    isset($_POST['guardar']) &&
    !empty($_POST['id_paciente']) &&
    !empty($_POST['id_consulta']) &&
    !empty($_POST['tipo']) &&
    !empty($_POST['descripcion']) &&
    !empty($_POST['ruta_archivos']) &&
    !empty($_POST['fecha_subida'])
) {

    $id_paciente   = $_POST['id_paciente'];
    $id_consulta   = $_POST['id_consulta'];
    $tipo          = $_POST['tipo'];
    $descripcion   = $_POST['descripcion'];
    $ruta_archivos = $_POST['ruta_archivos'];
    $fecha_subida  = $_POST['fecha_subida'];

    $sql = "INSERT INTO documentospacientes 
            (id_paciente, id_consulta, tipo, descripcion, ruta_archivos, fecha_subida)
            VALUES 
            ('$id_paciente', '$id_consulta', '$tipo', '$descripcion', '$ruta_archivos', '$fecha_subida')";

    if ($conexion->query($sql)) {
        header("Location: documentos_personas.php");
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
<title>Documentos Pacientes</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>
<?php if (isset($_GET['eliminado'])): ?>
<p class="mensaje-exito"> Documento eliminado</p>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
<p class="mensaje-exito"> Documento actualizado</p>
<?php endif; ?>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>DOCUMENTOS PACIENTES</h1>
</header>

<nav>
    <ul>
        <li><a href="admin01.html">Inicio</a></li>
    </ul>
</nav>

<h2>Registrar Documento</h2><BR>

<form action="documentos_personas.php" method="POST">

<label>Paciente:</label>
<select name="id_paciente" required>
    <option value="">Seleccione...</option>
    <?php while ($p = $pacientes->fetch_assoc()) { ?>
        <option value="<?= $p['id_paciente'] ?>">
            <?= $p['id_paciente'] . " - " . $p['nombre'] ?>
        </option>
    <?php } ?>
</select>

<label>Consulta:</label>
<select name="id_consulta" required>
    <option value="">Seleccione...</option>
    <?php while ($c = $consultas->fetch_assoc()) { ?>
        <option value="<?= $c['id_consulta'] ?>">
            <?= $c['id_consulta'] ?>
        </option>
    <?php } ?>
</select>

<label>Tipo:</label>
<input type="text" name="tipo" required>

<label>Descripción:</label>
<input type="text" name="descripcion" required>

<label>Ruta de archivos:</label>
<input type="text" name="ruta_archivos" required>

<label>Fecha de subida:</label>
<input type="datetime-local" name="fecha_subida" required>

<button type="submit" name="guardar">Guardar</button>


</form><BR>

<h2>Lista de Documentos</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Consulta</th>
    <th>Tipo</th>
    <th>Descripción</th>
    <th>Ruta archivos</th>
    <th>Fecha subida</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM documentospacientes");
while ($fila = $consulta->fetch_assoc()) {
?>
<tr>
    <td><?= $fila['id_documentos'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['id_consulta'] ?></td>
    <td><?= $fila['tipo'] ?></td>
    <td><?= $fila['descripcion'] ?></td>
    <td><?= $fila['ruta_archivos'] ?></td>
    <td><?= $fila['fecha_subida'] ?></td>
<td>
     <button><a href="documento_editar.php?id=<?= $fila['id_documentos'] ?>" class="btn">Editar</a> </button>
    <button onclick="confirmarEliminar(<?= $fila['id_documentos'] ?>)">Eliminar</button>
</td>

</tr>
<?php } ?>
</tbody>
</table>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar este documento?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "documento_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>

</body>
</html>
