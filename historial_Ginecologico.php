<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ===============================
   CARGAR MÉTODOS ANTICONCEPTIVOS
================================ */
$metodos = $conexion->query("SELECT id_metodo, nombre FROM metidos_anticonceptivos");
if (!$metodos) {
    die("Error métodos: " . $conexion->error);
}

/* ===============================
   CARGAR PACIENTES
================================ */
$pacientes = $conexion->query("SELECT id_paciente, nombre FROM pacientes");
if (!$pacientes) {
    die("Error pacientes: " . $conexion->error);
}

/* ===============================
   GUARDAR REGISTRO
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "INSERT INTO historial_Ginecologico (
        id_metodo, id_paciente, mecarquia, menorquia, ciclos_regulares,
        duracion_ciclos_dias, dolor_mertrual, embarazo, partos,
        cesarias, abortos, ultima_citologia, notas
    ) VALUES (
        '{$_POST['id_metodo']}',
        '{$_POST['id_paciente']}',
        '{$_POST['mecarquia']}',
        '{$_POST['menorquia']}',
        '{$_POST['ciclos_regulares']}',
        '{$_POST['duracion_ciclos_dias']}',
        '{$_POST['dolor_mertrual']}',
        '{$_POST['embarazo']}',
        '{$_POST['partos']}',
        '{$_POST['cesarias']}',
        '{$_POST['abortos']}',
        '{$_POST['ultima_citologia']}',
        '{$_POST['notas']}'
    )";

    if ($conexion->query($sql)) {
        header("Location: historial_Ginecologico.php");
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
<title>Historial Ginecológico</title>
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
    <h1>HISTORIAL GINECOLOGICO</h1>
</header>

<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>

<h2>Registrar historial ginecologico</h2><BR>

<form action="historial_Ginecologico.php" method="POST">

<label>Método anticonceptivo:</label>
<select name="id_metodo" required>
    <option value="">Seleccione...</option>
    <?php while ($m = $metodos->fetch_assoc()) { ?>
        <option value="<?= $m['id_metodo'] ?>"><?= $m['nombre'] ?></option>
    <?php } ?>
</select>

<label>Paciente:</label>
<select name="id_paciente" required>
    <option value="">Seleccione...</option>
    <?php while ($p = $pacientes->fetch_assoc()) { ?>
        <option value="<?= $p['id_paciente'] ?>"><?= $p['nombre'] ?></option>
    <?php } ?>
</select>

<label>Mecarquia:</label>
<input type="number" name="mecarquia" required>

<label>Menorquia:</label>
<input type="number" name="menorquia" required>

<label>Ciclos regulares (0/1):</label>
<input type="number" name="ciclos_regulares" required>

<label>Duración del ciclo (días):</label>
<input type="number" name="duracion_ciclos_dias" required>

<label>Dolor menstrual (0/1):</label>
<input type="number" name="dolor_mertrual" required>

<label>Embarazos:</label>
<input type="number" name="embarazo" required>

<label>Partos:</label>
<input type="number" name="partos" required>

<label>Cesáreas:</label>
<input type="number" name="cesarias" required>

<label>Abortos:</label>
<input type="number" name="abortos" required>

<label>Última citología:</label>
<input type="date" name="ultima_citologia" required>

<label>Notas:</label>
<input type="text" name="notas">

<button type="submit">Guardar</button>
</form><BR>


<!-- ===============================
     LISTADO
================================ -->
<h2>Lista Historial Ginecológico</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Método</th>
    <th>Paciente</th>
    <th>Mecarquia</th>
    <th>Menorquia</th>
    <th>Ciclos</th>
    <th>Duración</th>
    <th>Dolor</th>
    <th>Embarazos</th>
    <th>Partos</th>
    <th>Cesáreas</th>
    <th>Abortos</th>
    <th>Citología</th>
    <th>Notas</th>
     <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM historial_Ginecologico");
if ($consulta) {
while ($fila = $consulta->fetch_assoc()) { ?>
<tr>
    <td><?= $fila['id_gine'] ?></td>
    <td><?= $fila['id_metodo'] ?></td>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['mecarquia'] ?></td>
    <td><?= $fila['menorquia'] ?></td>
    <td><?= $fila['ciclos_regulares'] ?></td>
    <td><?= $fila['duracion_ciclos_dias'] ?></td>
    <td><?= $fila['dolor_mertrual'] ?></td>
    <td><?= $fila['embarazo'] ?></td>
    <td><?= $fila['partos'] ?></td>
    <td><?= $fila['cesarias'] ?></td>
    <td><?= $fila['abortos'] ?></td>
    <td><?= $fila['ultima_citologia'] ?></td>
    <td><?= $fila['notas'] ?></td>
   




<td>
      <button><a href="editar_ginecologico.php?id=<?= $fila['id_gine'] ?>" class="btn-editar">
    Editar
</a> </button>

    <button onclick="confirmarEliminar(<?= $fila['id_gine'] ?>)">Eliminar</button>
</td>
</tr>
<?php }} ?>
</tbody>
</table>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar este historial ginecologico?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "eliminar_ginecologico.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>
</body>
</html>
