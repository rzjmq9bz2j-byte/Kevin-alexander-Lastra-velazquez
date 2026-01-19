<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

/* GUARDAR CAMBIOS */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "UPDATE historial_Ginecologico SET
        mecarquia = '{$_POST['mecarquia']}',
        menorquia = '{$_POST['menorquia']}',
        ciclos_regulares = '{$_POST['ciclos_regulares']}',
        duracion_ciclos_dias = '{$_POST['duracion_ciclos_dias']}',
        dolor_mertrual = '{$_POST['dolor_mertrual']}',
        embarazo = '{$_POST['embarazo']}',
        partos = '{$_POST['partos']}',
        cesarias = '{$_POST['cesarias']}',
        abortos = '{$_POST['abortos']}',
        ultima_citologia = '{$_POST['ultima_citologia']}',
        notas = '{$_POST['notas']}'
        WHERE id_gine = '$id'
    ";

    if ($conexion->query($sql)) {
        header("Location: historial_Ginecologico.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR DATOS */
$consulta = $conexion->query("SELECT * FROM historial_Ginecologico WHERE id_gine = '$id'");
$datos = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Historial Ginecológico</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<h2>Editar historial ginecológico</h2>

<form method="POST">

<label>Mecarquia:</label>
<input type="number" name="mecarquia" value="<?= $datos['mecarquia'] ?>" required>

<label>Menorquia:</label>
<input type="number" name="menorquia" value="<?= $datos['menorquia'] ?>" required>

<label>Ciclos regulares (0/1):</label>
<input type="number" name="ciclos_regulares" value="<?= $datos['ciclos_regulares'] ?>" required>

<label>Duración del ciclo:</label>
<input type="number" name="duracion_ciclos_dias" value="<?= $datos['duracion_ciclos_dias'] ?>" required>

<label>Dolor menstrual (0/1):</label>
<input type="number" name="dolor_mertrual" value="<?= $datos['dolor_mertrual'] ?>" required>

<label>Embarazos:</label>
<input type="number" name="embarazo" value="<?= $datos['embarazo'] ?>" required>

<label>Partos:</label>
<input type="number" name="partos" value="<?= $datos['partos'] ?>" required>

<label>Cesáreas:</label>
<input type="number" name="cesarias" value="<?= $datos['cesarias'] ?>" required>

<label>Abortos:</label>
<input type="number" name="abortos" value="<?= $datos['abortos'] ?>" required>

<label>Última citología:</label>
<input type="date" name="ultima_citologia" value="<?= $datos['ultima_citologia'] ?>" required>

<label>Notas:</label>
<input type="text" name="notas" value="<?= $datos['notas'] ?>">

<button type="submit">Guardar cambios</button>


</form>

</body>
</html>
