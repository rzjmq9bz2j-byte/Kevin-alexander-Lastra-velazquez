<?php
include "conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nombre = $_POST['nombre'] ?? '';
$apellido_paterno = $_POST['apellido_paterno'] ?? '';
$apellido_materno = $_POST['apellido_materno'] ?? '';

if ($nombre == "" || $apellido_paterno == "" || $apellido_materno == "") {
    echo "Faltan datos.";
    exit;
}

$sql = "SELECT * FROM pacientes 
        WHERE nombre = '$nombre' AND apellido_paterno = '$apellido_paterno' AND apellido_materno = '$apellido_materno'";

$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
    echo "<h3>No se encontró ningún paciente con ese nombre y apellido</h3>";
    exit;
}

$paciente = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Expediente del Paciente</title>
<link rel="stylesheet" href="buscar_pacientes.css">
</head>
<body>

<div class="container">
 <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>


<h2>Datos del paciente</h2>

<div class="result-box">
<p><strong>ID:</strong> <?= $paciente['id_paciente'] ?></p>
<p><strong>Nombre:</strong> <?= $paciente['nombre'] ?></p>
<p><strong>Apellido paterno:</strong> <?= $paciente['apellido_paterno'] ?></p>
<p><strong>Apellido materno:</strong> <?= $paciente['apellido_materno'] ?></p>
<p><strong>curp:</strong> <?= $paciente['curp'] ?></p>
<p><strong>Fecha de nacimiento:</strong> <?= $paciente['fecha_nacimiento'] ?></p>
<p><strong>Genero:</strong> <?= $paciente['genero'] ?></p>
<p><strong>Teléfono:</strong> <?= $paciente['telefono'] ?></p>
<p><strong>Dirección:</strong> <?= $paciente['direccion'] ?></p>
</div>

<div class="fila">
<a href="hacer_cita.php">
            <button class="btn">hacer una cita
            </button>
        </a>

        <a href="seleccion_paciente.html">
            <button class="btn">Regresar
            </button>
        </a>

<a href="platicas/platicas.html">
            <button class="btn">Platicas 
            </button>
        </a>

        </div>
</div>

</body>
</html>