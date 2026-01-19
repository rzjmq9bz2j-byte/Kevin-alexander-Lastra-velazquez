<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===============================
// CARGAR USUARIOS
// ===============================
$usuarios = $conexion->query("SELECT id_usuario, nombre_usuario FROM usuario");
if (!$usuarios) {
    die("Error cargando usuarios: " . $conexion->error);
}

// ===============================
// GUARDAR REGISTRO
// ===============================
if (
    isset($_POST['guardar']) &&
    !empty($_POST['id_usuario']) &&
    !empty($_POST['accionarial']) &&
    !empty($_POST['detalles']) &&
    !empty($_POST['fecha_hora'])
) {

    $id_usuario  = $_POST['id_usuario'];
    $accionarial = $_POST['accionarial'];
    $detalles    = $_POST['detalles'];
    $fecha_hora  = $_POST['fecha_hora'];

    $sql = "INSERT INTO auditoria
            (id_usuario, accionarial, detalles, fecha_hora)
            VALUES
            ('$id_usuario', '$accionarial', '$detalles', '$fecha_hora')";

    if ($conexion->query($sql)) {
        header("Location: auditoria.php");
        exit;
    } else {
        echo "Error al guardar: " . $conexion->error;
    }
}

?>
<?php if (isset($_GET['eliminado'])): ?>
<p class="mensaje-exito">✅ Registro eliminado</p>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
<p class="mensaje-exito">✏️ Registro actualizado</p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Auditoría</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<header>
        <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>AUDITORÍA</h1>
</header>

<nav>
    <ul>
        
        <li><a href="admin01.html">Inicio</a></li>
    </ul>
</nav>

<h2>Registrar Auditoría</h2><BR>

<form action="auditoria.php" method="POST">

<label>Usuario:</label>
<select name="id_usuario" required>
    <option value="">Seleccione...</option>
    <?php while ($u = $usuarios->fetch_assoc()) { ?>
        <option value="<?= $u['id_usuario'] ?>">
            <?= $u['id_usuario'] . " - " . $u['nombre_usuario'] ?>
        </option>
    <?php } ?>
</select>

<label>Acción:</label>
<input type="text" name="accionarial" required>

<label>Detalles:</label>
<input type="text" name="detalles" required>

<label>Fecha y hora:</label>
<input type="datetime-local" name="fecha_hora" required>

<button type="submit" name="guardar">Guardar</button>


</form><BR>

<h2>Lista de Auditoría</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Acción</th>
    <th>Detalles</th>
    <th>Fecha y hora</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM auditoria");
while ($fila = $consulta->fetch_assoc()) {
?>
<tr>
    <td><?= $fila['id_log'] ?></td>
    <td><?= $fila['id_usuario'] ?></td>
    <td><?= $fila['accionarial'] ?></td>
    <td><?= $fila['detalles'] ?></td>
    <td><?= $fila['fecha_hora'] ?></td>
  <td>
   <button> <a href="auditoria_editar.php?id=<?= $fila['id_log'] ?>" class="btn">Editar</a></button>
    <button onclick="confirmacionEliminacion(<?= $fila['id_log'] ?>)">Eliminar</button>
</td>

</tr>
<?php } ?>
</tbody>
</table>



<div id="confirmarModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
<div style="background:white;padding:20px;width:300px;margin:15% auto;border-radius:10px;text-align:center;">
<p>¿Eliminar auditoria?</p>
<button onclick="cerrarModal()">Cancelar</button>
<a id="btnEliminarConfirmado" href="#">Eliminar</a>
</div></div>

<script>
function confirmacionEliminacion(id){
    document.getElementById("btnEliminarConfirmado").href = "auditoria_eliminar.php?id=" + id;
    document.getElementById("confirmarModal").style.display = "block";
}
function cerrarModal(){
    document.getElementById("confirmarModal").style.display = "none";
}
</script>
</body>
</html>
