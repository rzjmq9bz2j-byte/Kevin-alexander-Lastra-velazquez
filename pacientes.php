<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// -------------------------------------------
// GUARDAR PACIENTE
// -------------------------------------------
if (
    !empty($_POST['nombre']) &&
    !empty($_POST['apellido_paterno']) &&
    !empty($_POST['apellido_materno']) &&
    !empty($_POST['curp']) &&
    !empty($_POST['fecha_nacimiento']) &&
    !empty($_POST['genero']) &&
    !empty($_POST['telefono']) &&
    !empty($_POST['direccion'])
) {

    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $curp = $_POST['curp'];
    $fecha = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO pacientes (nombre, apellido_paterno, apellido_materno, curp, fecha_nacimiento, genero, telefono, direccion)
            VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$curp', '$fecha', '$genero', '$telefono', '$direccion')";

    if ($conexion->query($sql)) {
        header("Location: pacientes.php");
        exit;
    } else {
        echo "Error al registrar: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pacientes</title>
  <link rel="stylesheet" href="pacientes.css">
</head>
<body>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>PACIENTES</h1>
</header>


<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>


<h2>Formulario de Pacientes</h2><BR>

<form action="pacientes.php" method="POST">

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Apellido Paterno:</label>
    <input type="text" name="apellido_paterno" required>

    <label>Apellido Materno:</label>
    <input type="text" name="apellido_materno" required>

    <label>CURP:</label>
    <input type="text" name="curp" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nacimiento" required>

    <label>Género:</label>
    <select name="genero" required>
        <option value="">Seleccionar...</option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
        <option value="Otro">Otro</option>
    </select>

    <label>Teléfono:</label>
    <input type="text" name="telefono" required>

    <label>Dirección:</label>
    <input type="text" name="direccion" required>

    <button type="submit">Guardar</button>
</form><BR>

























<h2>Lista de Pacientes</h2>

<table border="1">
<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Apellido Paterno</th>
    <th>Apellido Materno</th>
    <th>CURP</th>
    <th>Fecha Nacimiento</th>
    <th>Género</th>
    <th>Teléfono</th>
    <th>Dirección</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php 
$consulta = $conexion->query("SELECT * FROM pacientes");
while($fila = $consulta->fetch_assoc()) { ?>
<tr>
    <td><?= $fila['id_paciente'] ?></td>
    <td><?= $fila['nombre'] ?></td>
    <td><?= $fila['apellido_paterno'] ?></td>
    <td><?= $fila['apellido_materno'] ?></td>
    <td><?= $fila['curp'] ?></td>
    <td><?= $fila['fecha_nacimiento'] ?></td>
    <td><?= $fila['genero'] ?></td>
    <td><?= $fila['telefono'] ?></td>
    <td><?= $fila['direccion'] ?></td>

    <td>
        <button><a href="paciente_editar.php?id=<?= $fila['id_paciente'] ?>">Editar</a></button>
        <button onclick="confirmacionEliminacion(<?= $fila['id_paciente'] ?>)">Eliminar</button>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<!-- Modal de confirmación -->
<div id="confirmarModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.6);">
  <div style="background:white; padding:20px; width:300px; margin:15% auto; border-radius:10px; text-align:center;">
    <h5>Confirmar eliminación</h5>
    <p>¿Estás seguro que deseas eliminar este registro?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminarConfirmado" href="#" style="padding:8px 12px; background:red; color:white; border-radius:5px; text-decoration:none;">Eliminar</a>
  </div>
</div>

<script>
function confirmacionEliminacion(id) {
    document.getElementById('btnEliminarConfirmado').href = 'paciente_eliminar.php?id=' + id;
    document.getElementById('confirmarModal').style.display = 'block';
}
function cerrarModal() {
    document.getElementById('confirmarModal').style.display = 'none';
}
</script>

</body>
</html>
