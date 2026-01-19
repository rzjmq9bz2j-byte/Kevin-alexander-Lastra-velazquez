<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// -------------------------------------------
// SI SE ENVÍA EL FORMULARIO → GUARDAR PACIENTE
// -------------------------------------------
$paciente = null;

if (
    isset($_POST['guardar']) &&
    !empty($_POST['nombre']) &&
    !empty($_POST['apellido_paterno']) &&
    !empty($_POST['apellido_materno']) &&
    !empty($_POST['curp']) &&
    !empty($_POST['fecha_nacimiento']) &&
    !empty($_POST['genero']) &&
    !empty($_POST['telefono']) &&
    !empty($_POST['direccion'])
) {

    // DATOS
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $curp = $_POST['curp'];
    $fecha = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // GUARDAR EN BD
    $sql = "INSERT INTO pacientes 
    (nombre, apellido_paterno, apellido_materno, curp, fecha_nacimiento, genero, telefono, direccion)
    VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$curp', '$fecha', '$genero', '$telefono', '$direccion')";

    if ($conexion->query($sql)) {

        // OBTENER EL PACIENTE RECIÉN REGISTRADO
        $id = $conexion->insert_id;
        $result = $conexion->query("SELECT * FROM pacientes WHERE id_paciente = $id");
        $paciente = $result->fetch_assoc();

        echo "<script>alert('Paciente registrado con éxito');</script>";

    } else {
        echo "Error: " . $conexion->error;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pacientes</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<header>
    <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>FORMULARIO DE PACIENTE</h1>
</header>

<nav>
    <ul>
        <li><a href="inicio.html">Inicio</a></li>
        
    </ul>
</nav>



<!-- SI NO HAY PACIENTE → MOSTRAR FORMULARIO -->
<?php if (!$paciente): ?>

<form method="POST">

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

    <button type="submit" name="guardar">Guardar</button>

</form>

<?php else: ?>

<!-- SI YA SE REGISTRÓ → MOSTRAR EXPEDIENTE -->
<div class="container">
<h2>Datos del paciente</h2>

<div class="result-box">
<p><strong>ID:</strong> <?= $paciente['id_paciente'] ?></p>
<p><strong>Nombre:</strong> <?= $paciente['nombre'] ?></p>
<p><strong>Apellido paterno:</strong> <?= $paciente['apellido_paterno'] ?></p>
<p><strong>Apellido materno:</strong> <?= $paciente['apellido_materno'] ?></p>
<p><strong>CURP:</strong> <?= $paciente['curp'] ?></p>
<p><strong>Fecha nacimiento:</strong> <?= $paciente['fecha_nacimiento'] ?></p>
<p><strong>Genero:</strong> <?= $paciente['genero'] ?></p>
<p><strong>Teléfono:</strong> <?= $paciente['telefono'] ?></p>
<p><strong>Dirección:</strong> <?= $paciente['direccion'] ?></p>
</div>

<div class="fila">

<a href="hacer_cunsulta.php">
    <button class="btn">Hacer una consulta</button>
</a>

<a href="nuevo_paciente.php">
    <button class="btn">Registrar otro paciente</button>
</a>

<a href="platicas/platicas.html">
    <button class="btn">Pláticas</button>
</a>

</div>
</div>

<?php endif; ?>

</body>
</html>
