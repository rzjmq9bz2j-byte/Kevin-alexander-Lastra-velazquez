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
// GUARDAR REGISTRO
// ===============================
if (
    !empty($_POST['id_paciente']) &&
    !empty($_POST['id_medico']) &&
    !empty($_POST['tipo']) &&
    !empty($_POST['descripcion']) &&
    !empty($_POST['fecha']) &&
    !empty($_POST['realizado_por']) &&
    !empty($_POST['resultado'])
) {

    $id_paciente = $_POST['id_paciente'];
    $id_medico   = $_POST['id_medico'];
    $tipo        = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha       = $_POST['fecha'];
    $realizado   = $_POST['realizado_por'];
    $resultado   = $_POST['resultado'];
    $archivo     = $_POST['archivo_resultado'];

    $sql = "INSERT INTO vacunas_estudios 
            (id_paciente, id_medico, tipo, descripcion, fecha, realizado_por, resultado, archivo_resultado)
            VALUES ('$id_paciente', '$id_medico', '$tipo', '$descripcion', '$fecha', '$realizado', '$resultado', '$archivo')";

    if ($conexion->query($sql)) {
        header("Location: vacunas.php");
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
<title>Vacunas y Estudios</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>Vacunas y Estudios</h1>
</header>
<nav>
    <ul>
        <li><a href="admin01.html">Inicio</a></li>
        
    </ul>
</nav>

<h2>Registrar Vacuna / Estudio</h2><BR>

<form action="vacunas.php" method="POST">

<!-- ==========================
     SELECT DINÁMICO PACIENTE
=========================== -->
<label>Paciente:</label>
<select name="id_paciente" required>
    <option value="">Seleccione...</option>

    <?php while ($p = $pacientes->fetch_assoc()) { ?>
        <option value="<?= $p['id_paciente'] ?>">
            <?= $p['id_paciente'] . " - " . $p['nombre'] ?>
        </option>
    <?php } ?>

</select>


<!-- ==========================
     SELECT DINÁMICO MÉDICO
=========================== -->
<label>Médico:</label>

<select name="id_medico" id="medicoSelect" required>
    <option value="">Seleccione...</option>

    <?php while ($m = $medicos->fetch_assoc()) { ?>
        <option value="<?= $m['id_medico'] ?>">
            <?= $m['id_medico'] . " - " . $m['nombre'] ?>
        </option>
    <?php } ?>
</select>


<label>Tipo:</label>
<select name="tipo" required>
    <option value="">Seleccionar...</option>
    <option value="vacuna">Vacuna</option>
    <option value="popanicolaou">Papanicolaou</option>
    <option value="ultrasonido">Ultrasonido</option>
    <option value="VIH">VIH</option>
    <option value="ETS">ETS</option>
    <option value="OTROS">Otros</option>
</select>



<label>Descripción:</label>
<input type="text" name="descripcion" required>

<label>Fecha:</label>
<input type="date" name="fecha" required>

<label>Realizado por:</label>
<input type="text" name="realizado_por" id="realizado_por" required>


<label>Resultado:</label>
<input type="text" name="resultado" required>

<label>Archivo resultado:</label>
<input type="text" name="archivo_resultado">

<button type="submit">Guardar</button>


</form><BR>










<h2>Lista de Vacunas y Estudios</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Médico</th>
    <th>Tipo</th>
    <th>Descripción</th>
    <th>Fecha</th>
    <th>Realizado por</th>
    <th>Resultado</th>
    <th>Archivo</th>
     <th>Acciones</th>
</tr>
</thead>

<tbody>

<?php
$consulta = $conexion->query("SELECT * FROM vacunas_estudios");

while ($fila = $consulta->fetch_assoc()) { ?>
<tr>
    <td><?= $fila['id_registro'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['id_medico'] ?></td>
    <td><?= $fila['tipo'] ?></td>
    <td><?= $fila['descripcion'] ?></td>
    <td><?= $fila['fecha'] ?></td>
    <td><?= $fila['realizado_por'] ?></td>
    <td><?= $fila['resultado'] ?></td>
    <td><?= $fila['archivo_resultado'] ?></td>
    <td>
       <button>
  <a href="vacunas_editar.php?id=<?= $fila['id_registro'] ?>">Editar</a>
</button>

<button onclick="confirmar(<?= $fila['id_registro'] ?>)">Eliminar</button>

        </td>
</tr>
<?php } ?>

</tbody>
</table>



<script>
document.getElementById("medicoSelect").addEventListener("change", function() {
    let idMedico = this.value;
    document.getElementById("realizado_por").value = idMedico;
});
</script>
<div id="modal" style="display:none; position:fixed; top:0; left:0;
width:100%; height:100%; background:rgba(0,0,0,.6);">

<div style="background:white; padding:20px; width:300px;
margin:15% auto; border-radius:10px; text-align:center;">

<h3>Eliminar Registro</h3>
<p>¿Seguro que deseas eliminar?</p>

<button onclick="cerrarModal()">Cancelar</button>

<a id="btnEliminar" href="#"
style="padding:8px 12px; background:red; color:white;
text-decoration:none; border-radius:5px;">Eliminar</a>

</div>
</div>

<script>
function confirmar(id){
    document.getElementById("btnEliminar").href = "vacunas_eliminar.php?id=" + id;
    document.getElementById("modal").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>

